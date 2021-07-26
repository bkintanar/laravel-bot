<?php

namespace App\Console\Commands;

use Exception;
use Monolog\Logger;
use App\Traits\HasOptions;
use Illuminate\Support\Carbon;
use Nesk\Puphpeteer\Puppeteer;
use Illuminate\Console\Command;
use Nesk\Rialto\Data\JsFunction;
use Monolog\Handler\StreamHandler;

class FormFillerCommand extends Command
{
    use HasOptions;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'adficient:fill-form {inputJsonFile} {--headless} {--no-intervention}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fills the form';

    /**
     * @var Puppeteer
     */
    protected $puppeteer;

    /**
     * @var
     */
    protected $page;

    /**
     * @var
     */
    protected $browser;

    /**
     * @var Logger
     */
    protected $logger;

    /**
     * @var array
     */
    protected $errors = [];

    /**
     * @var string
     */
    protected $url = 'https://irs-gov-ein-online.com/llc-demo/';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $headless = $this->option('headless');
        $noIntervention = $this->option('no-intervention');

        $answers = $this->jsonValuesMapper($noIntervention);

        if ($this->errors) {
            foreach ($this->errors as $error) {
                $this->error($error);
            }

            return 0;
        }

        try {
            $this->initializeLogger();

            $this->initializePuPHPeteer($headless);

            $this->acceptJsAlert();

            $this->page->goto($this->url, ['timeout' => 60000]);

            foreach ($answers as $key => $answer) {
                if (array_key_exists($key, $this->optionFieldPair) && ! in_array($key, array_keys($this->options['payment_information']))) {
                    $this->processField($this->optionFieldPair[$key], $answer);
                }
            }

            // accepts agreement
            $checkbox = $this->page->querySelector('#input_30_54_1');
            $checkbox->click();

            $this->storeScreenshot('form-before-submit.png');

            // submit application
            $submitButton = $this->page->querySelector('#gform_next_button_30_58');
            $submitButton->click();

            sleep(5);

            $this->storeScreenshot('form-after-submit.png');

            if ($this->hasValidationError()) {
                $this->warn('Form failed to validate. Please refer to the `form-after-submit.png` screenshot for information.');

                $this->browser->close();

                return 1;
            }

            $this->processPayment($answers);
        } catch (Exception $e) {
            $this->warn('Error caught: ' . $e->getMessage());
            $this->warn('Bailing out...');

            throw $e;
        }

        return 0;
    }

    protected function acceptJsAlert()
    {
        $jsFunction = JsFunction::createWithAsync()
            ->parameters(['dialog'])
            ->body('await dialog.accept();');

        $this->page->on('dialog', $jsFunction);
    }

    protected function fillInputField($fieldProperties, string $value)
    {
        $ids = $fieldProperties['id'];
        if (! is_array($ids)) {
            $ids = [$fieldProperties['id']];
        }

        foreach ($ids as $id) {
            $this->info("[INFO] Filling input field {$id} with value: {$value}.");

            $jsFunction = JsFunction::createWithParameters(['el'])->body("el.value = '$value'");

            $this->page->querySelectorEval($id, $jsFunction);
        }
    }

    protected function selectRadioButton($fieldProperties, $value)
    {
        $id = $fieldProperties['ids'][$value];
        $this->info("[INFO] Selecting radio button {$id}.");

        $radioButton = $this->page->querySelector($id);

        $radioButton->click();
    }

    protected function selectCheckbox($fieldProperties, $value)
    {
        $id = $fieldProperties['ids'][$value];
        $this->info("[INFO] Selecting checkbox {$id}.");

        $checkbox = $this->page->querySelector($id);

        $checkbox->click();
    }

    protected function selectSpecial($fieldProperties, $value)
    {
        $isOther = false;
        $keys = array_keys($fieldProperties['ids']);
        if (! array_key_exists($value, $fieldProperties['ids']) && end($keys) == 'Other') {
            $isOther = true;
            $id = $fieldProperties['ids']['Other'][0];
        } else {
            $id = $fieldProperties['ids'][$value];
        }

        $this->info("[INFO] Selecting radio button {$id}.");

        $radioButton = $this->page->querySelector($id);

        $radioButton->click();

        if ($isOther) {
            $id = $fieldProperties['ids']['Other'][1];

            $this->info("[INFO] Filling input field {$id} with value: {$value}.");

            $jsFunction = JsFunction::createWithParameters(['el'])->body("el.value = '$value'");

            $this->page->querySelectorEval($id, $jsFunction);
        }
    }

    protected function selectDropdown($fieldProperties, string $value)
    {
        $id = $fieldProperties['id'];
        $this->info("[INFO] Selecting dropdown menu {$id} with value: {$value}.");

        $this->page->select($id, $value);
    }

    protected function selectDate($fieldProperties, string $value)
    {
        $ids = $fieldProperties['ids'];

        $value = Carbon::parse($value);
        $date = [
            $value->format('m'),
            $value->format('d'),
            $value->format('Y'),
        ];

        foreach ($ids as $key => $id) {
            $properties = ['id' => $id];
            $this->selectDropdown($properties, (string) $date[$key]);
        }
    }

    protected function fillCouponField($fieldProperties, string $value)
    {
        $this->storeScreenshot('form-before-coupon-apply.png');

        $ids = $fieldProperties['ids'];

        $this->page->focus($ids[0]);
        $this->page->keyboard->type($value);

        $id = $fieldProperties['ids'][1];
        $this->info("[INFO] Clicking apply coupon button {$id}.");

        $couponButton = $this->page->querySelector($id);

        $couponButton->click();

        sleep(5);

        $this->storeScreenshot('form-after-coupon-apply.png');
    }

    protected function fillPaymentField($fieldProperties, string $value)
    {
        $submitButton = $this->page->waitForSelector('#gform_submit_button_30');
        $submitButton->click();

        $name = $fieldProperties['name'];

        $this->info("[INFO] Filling payment field {$name} with value: {$value}.");

        $elementHandle = $this->page->waitForSelector('iframe');
        $frame = $elementHandle->contentFrame();

        $frame->focus($name);
        $frame->type($name, $value);
    }

    protected function storeScreenshot($filename = 'output.png')
    {
        $filepath = storage_path("screenshots/{$filename}");

        $this->page->screenshot(['path' => $filepath, 'fullPage' => true]);

        $this->info("[INFO] Screenshot saved: {$filepath}");
    }

    protected function initializeLogger()
    {
        $this->info('Initializing Logger using Monolog.');

        $logPath = storage_path('logs/puphpeteer.log');

        $this->logger = new Logger('PuPHPeteer');
        $this->logger->pushHandler(new StreamHandler($logPath, Logger::DEBUG));
    }

    protected function initializePuPHPeteer($headless = true)
    {
        $this->info('Initializing PuPHPeteer.');

        $this->puppeteer = new Puppeteer([
            'logger'              => $this->logger,
            'log_node_console'    => true,
            'log_browser_console' => true,
            'read_timeout'        => 60,
        ]);

        $args = [];
        if (! $headless) {
            $args = ['--disable-features=IsolateOrigins,site-per-process', '--disable-web-security'];
        }

        $this->browser = $this->puppeteer->launch(['headless' => $headless, 'args' => $args]);

        $this->page = $this->browser->newPage();

        $this->page->setViewport(['width' => 1920, 'height' => 1080]);
    }

    protected function processField($fieldProperties, $answer)
    {
        switch ($fieldProperties['type']) {
            case 'phone':
                $part1 = substr($answer, 0, 3);
                $part2 = substr($answer, 3, 3);
                $part3 = substr($answer, 6);

                $answer = "({$part1}) {$part2}-{$part3}";

                // no break
            case 'text':
                $this->fillInputField($fieldProperties, $answer);
                break;

            case 'ssn':
                $part1 = substr($answer, 0, 3);
                $part2 = substr($answer, 3, 2);
                $part3 = substr($answer, 5);

                $answer = "{$part1}-{$part2}-{$part3}";

                $this->fillInputField($fieldProperties, $answer);
                break;
            case 'radio':
                $this->selectRadioButton($fieldProperties, $answer);
                break;
            case 'select':
                $this->selectDropdown($fieldProperties, $answer);
                break;
            case 'select-state-code':
                $states = array_flip($this->states);

                $this->selectDropdown($fieldProperties, $states[$answer]);
                break;
            case 'date':
                $this->selectDate($fieldProperties, $answer);
                break;
            case 'special':
                $this->selectSpecial($fieldProperties, $answer);
                break;
            case 'coupon':
                $this->fillCouponField($fieldProperties, $answer);
                break;
            case 'payment':
                $this->fillPaymentField($fieldProperties, $answer);
                break;
        }
    }

    protected function processPayment($answers)
    {
        $this->page->waitForSelector('#gform_submit_button_30');

        $paymentPageSubmitButton = $this->page->querySelector('#gform_submit_button_30');

        $paymentFields = array_flip($this->options['payment_information']);

        foreach ($paymentFields as $paymentField) {
            if (array_key_exists($paymentField, $answers)) {
                $this->processField($this->optionFieldPair[$paymentField], $answers[$paymentField]);
            }
        }

        $this->storeScreenshot('form-before-submit-payment.png');

        // submit application
        $paymentPageSubmitButton->click();

        sleep(5);
//
        $this->storeScreenshot('form-after-submit-payment.png');

        $this->browser->close();
    }

    protected function hasValidationError()
    {
        $el = $this->page->querySelectorAll('.gform_validation_error');

        return count($el);
    }
}
