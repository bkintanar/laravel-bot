<?php

namespace App\Traits;

use App\Validators\DateValidator;
use App\Validators\EmailValidator;
use App\Validators\StateValidator;
use App\Validators\DefaultValidator;
use App\Validators\KeywordValidator;
use App\Validators\PhoneNumberValidator;
use App\Validators\SocialSecurityValidator;

trait HasOptions
{
    /**
     * @var mixed
     */
    protected $jsonFileContents;

    protected $options = [
        'llc_information' => [
            'legal_name'                   => 'Legal Name of LLC Business',
            'has_dba'                      => 'Does this LLC have a DBA?',
            'number_of_llc_members'        => 'Number of LLC Members', // min 1; max 20;
            'state_organization_are_filed' => 'State / Territory where articles of organization are (or will be) filed',
            'state_business_is_located'    => 'State / Territory where business is physcially located',
            'date_entity_was_started'      => 'Date entity was started or acquired', // mm/dd/yyyy
        ],
        'responsible_party_information' => [
            'first_name'         => 'First Name',
            'middle_name'        => 'Middle Name',
            'last_name'          => 'Last Name',
            'suffix'             => 'Suffix', // DDS, MD, PHD, JR, SR, I, II, III, IV, V, VI
            'title'              => 'Title',   // CEO, Executor, Owner, Managing Member, Managing Member/Owner, President, Other
            'social_security_no' => 'Social Security #', // ###-###-###
        ],
        'business_address' => [
            'address_1'             => 'Address',
            'address_2'             => 'Address 2',
            'city'                  => 'Address > City',
            'state'                 => 'Address > State',
            'zip_code'              => 'Address > Zip Code',
            'country'               => 'Address > Country',
            'use_different_mailing' => 'Do you want to receive your mail at another address?',
        ],
        'about_the_business_entity' => [
            'reason_for_applying' => 'Reason for Applying',
            'primary_activity' => 'Primary Activity',
            'has_highway_motor_vehicle' => 'Does your business own a highway motor vehicle with a taxable gross weight of 55,000 pounds or more?',
            'business_involves_gambling' => 'Does your business involve gambling/wagering?',
            'need_to_file_form_720' => 'Does your business need to file Form 720 (Quarterly Federal Excise Tax Return)?',
            'sell_or_manufacture_alcohol_tobacco_firearms' => 'Does your business own a highway motor vehicle with a taxable gross weight of 55,000 pounds or more?',
            'will_receive_forms_w_2' => 'Do you have, or do you expect to have, any employees who will receive Forms W-2 in the next 12 months?',
            'applied_for_an_ein_before' => 'Has this LLC ever received or applied for an EIN before?',
        ],
        'contact_information' => [
            'recipient_email' => 'Recipient Email',
            'recipient_phone' => 'Recipient Phone Number',
        ],
        'payment_information' => [
            'coupon' => 'Apply a coupon',
            'card_number' => 'Credit card number',
            'expiration_date' => 'Expiration Date: MM/YY format',
            'cvc' => 'CVC Number',
            'name_on_card' => 'Name on card',
        ],
    ];

    protected $optionFieldPair = [
        'legal_name' => [
            'type' => 'text',
            'id'   => '#input_30_6',
        ],
        'has_dba' => [
            'type' => 'radio',
            'ids' => ['#choice_30_7_0', '#choice_30_7_1'],
        ],
        'trade_name' => [
            'type' => 'text',
            'id'   => '#input_30_8',
        ],
        'number_of_llc_members' => [
            'type' => 'select',
            'id'   => '#input_30_10',
        ],
        'state_organization_are_filed' => [
            'type' => 'select',
            'id'   => '#input_30_11',
        ],
        'state_business_is_located' => [
            'type' => 'select',
            'id'   => '#input_30_12',
        ],
        'date_entity_was_started' => [
            'type' => 'date',
            'ids'   => ['#input_30_36_1', '#input_30_36_2', '#input_30_36_3'],
        ],
        'first_name' => [
            'type' => 'text',
            'id'   => '#input_30_14',
        ],
        'middle_name' => [
            'type' => 'text',
            'id'   => '#input_30_15',
        ],
        'last_name' => [
            'type' => 'text',
            'id'   => '#input_30_16',
        ],
        'suffix' => [
            'type' => 'select',
            'id'   => '#input_30_17',
        ],
        'title' => [
            'type' => 'select',
            'id'   => '#input_30_18',
        ],
        'social_security_no' => [
            'type' => 'ssn',
            'id'   => ['#input_30_20', '#input_30_108'],
        ],
        'address_1' => [
            'type' => 'text',
            'id'   => '#input_30_65_1',
        ],
        'address_2' => [
            'type' => 'text',
            'id'   => '#input_30_65_2',
        ],
        'city' => [
            'type' => 'text',
            'id'   => '#input_30_65_3',
        ],
        'state' => [
            'type' => 'select-state-code',
            'id'   => '#input_30_65_4',
        ],
        'zip_code' => [
            'type' => 'text',
            'id'   => '#input_30_65_5',
        ],
        'country' => [
            'type' => 'text',
            'id'   => '#input_30_28',
        ],
        'use_different_mailing' => [
            'type' => 'radio',
            'ids'   => ['#choice_30_29_0', '#choice_30_29_1'],
        ],

        'mailing_address_1' => [
            'type' => 'text',
            'id'   => '#input_30_66_1',
        ],
        'mailing_address_2' => [
            'type' => 'text',
            'id'   => '#input_30_66_2',
        ],
        'mailing_city' => [
            'type' => 'text',
            'id'   => '#input_30_66_3',
        ],
        'mailing_state' => [
            'type' => 'select-state-code',
            'id'   => '#input_30_66_4',
        ],
        'mailing_zip_code' => [
            'type' => 'text',
            'id'   => '#input_30_66_5',
        ],
        'reason_for_applying' => [
            'type' => 'select',
            'id'   => '#input_30_38',
        ],
        'primary_activity' => [
            'type' => 'select',
            'id'   => '#input_30_39',
        ],
        'accomodation_type' => [
            'type' => 'special',
            'ids' => [
                'Casino Hotel' => '#choice_30_67_0',
                'Hotel' => '#choice_30_67_1',
                'Motel' => '#choice_30_67_2',
                'Other' => ['#choice_30_67_3', '#input_30_67_other'],
            ],
        ],
        'construction_type' => [
            'type' => 'radio',
            'ids' => ['#choice_30_69_1', '#choice_30_69_0'],
        ],
        'finance_type' => [
            'type' => 'special',
            'ids' => [
                'Commodities broker' => '#choice_30_73_0',
                'Credit card issuing' => '#choice_30_73_1',
                'Investment advice' => '#choice_30_73_2',
                'Investment club' => '#choice_30_73_3',
                'Investment holding' => '#choice_30_73_4',
                'Mortgage broker – agent for selling mortgages' => '#choice_30_73_5',
                'Mortgage company – lending funds with real estate as collateral' => '#choice_30_73_6',
                'Portfolio management' => '#choice_30_73_7',
                'Sales financing' => '#choice_30_73_8',
                'Securities broker' => '#choice_30_73_9',
                'Trust administration' => '#choice_30_73_10',
                'Venture capital company' => '#choice_30_73_11',
                'Other' => ['#choice_30_73_12', '#input_30_73_other'],
            ],
        ],
        'food_service_type' => [
            'type' => 'special',
            'ids' => [
                'Bar' => '#choice_30_74_0',
                'Bar and restaurant' => '#choice_30_74_1',
                'Catering service' => '#choice_30_74_2',
                'Coffee shop' => '#choice_30_74_3',
                'Fast food restaurant' => '#choice_30_74_4',
                'Full service restaurant' => '#choice_30_74_5',
                'Ice cream shop' => '#choice_30_74_6',
                'Mobile food service' => '#choice_30_74_7',
                'Other' => ['#choice_30_74_8', '#input_30_74_other'],
            ],
        ],
        'health_care_type' => [
            'type' => 'radio',
            'ids' => ['#choice_30_75_0', '#choice_30_75_1'],
        ],
        'insurance_type' => [
            'type' => 'special',
            'ids' => [
                'I am an insurance carrier' => '#choice_30_80_0',
                'I am an insurance agent or broker' => '#choice_30_80_1',
                'Other' => ['#choice_30_80_2', '#input_30_80_other'],
            ],
        ],
        'manufacturing_type' => [
            'type' => 'text',
            'id' => '#input_30_90',
        ],
        'real_estate_type' => [
            'type' => 'special',
            'ids' => [
                'I rent or lease property that I own' => '#choice_30_68_0',
                'I use capital to build property' => '#choice_30_68_1',
                'I sell property for others' => '#choice_30_68_2',
                'I manage real estate for others' => 'choice_30_68_3',
                'Other' => ['#choice_30_68_4', '#input_30_68_other'],
            ],
        ],
        'rental_leasing_type' => [
            'type' => 'special',
            'ids' => [
                'I rent, lease, or sell real estate' => '#choice_30_92_0',
                'I manage real estate for others' => '#choice_30_92_1',
                'I rent or lease goods' => '#choice_30_92_2',
            ],
        ],
        'retail_type' => [
            'type' => 'special',
            'ids' => [
                'Selling goods exclusively over the Internet (includes independently selling on auction sites)' => '#choice_30_97_0',
                'Sales from a storefront' => '#choice_30_97_1',
                'Direct sales' => '#choice_30_97_2',
                'Auction house' => 'choice_30_97_3',
                'Other' => ['#choice_30_97_4', '#input_30_97_other'],
            ],
        ],
        'social_assistance_type' => [
            'type' => 'special',
            'ids' => [
                'Nursing home' => '#choice_30_82_0',
                'Shelter' => '#choice_30_82_1',
                'Youth services' => '#choice_30_82_2',
                'Other' => ['#choice_30_82_3', '#input_30_82_other'],
            ],
        ],
        'wholesale_type' => [
            'type' => 'radio',
            'ids' => ['#choice_30_101_1', '#choice_30_101_0'],
        ],
        'other_type' => [
            'type' => 'special',
            'ids' => [
                'Consulting' => '#choice_30_87_0',
                'Manufacturing' => '#choice_30_87_1',
                'Organization (such as religious, environmental, social or civic, athletic, etc.)' => '#choice_30_87_2',
                'Rental' => '#choice_30_87_3',
                'Repair' => '#choice_30_87_4',
                'Sell goods' => '#choice_30_87_5',
                'Service' => '#choice_30_87_6',
                'Other' => ['#choice_30_87_7', '#input_30_87_other'],
            ],
        ],
        'has_highway_motor_vehicle' => [
            'type' => 'radio',
            'ids'   => ['#choice_30_42_0', '#choice_30_42_1'],
        ],
        'business_involves_gambling' => [
            'type' => 'radio',
            'ids'   => ['#choice_30_43_0', '#choice_30_43_1'],
        ],
        'need_to_file_form_720' => [
            'type' => 'radio',
            'ids'   => ['#choice_30_44_0', '#choice_30_44_1'],
        ],
        'sell_or_manufacture_alcohol_tobacco_firearms' => [
            'type' => 'radio',
            'ids'   => ['#choice_30_45_0', '#choice_30_45_1'],
        ],
        'will_receive_forms_w_2' => [
            'type' => 'radio',
            'ids'   => ['#choice_30_46_0', '#choice_30_46_1'],
        ],
        'tax_liability_less_1000' => [
            'type' => 'radio',
            'ids'   => ['#choice_30_47_0', '#choice_30_47_1'],
        ],
        'number_agricultural_employees' => [
            'type' => 'text',
            'id'   => '#input_30_114',
        ],
        'number_other_employees' => [
            'type' => 'text',
            'id'   => '#input_30_115',
        ],
        'first_date_wages' => [
            'type' => 'date',
            'ids'   => ['#input_30_50_1', '#input_30_50_2', '#input_30_50_3'],
        ],
        'applied_for_an_ein_before' => [
            'type' => 'radio',
            'ids'   => ['#choice_30_51_0', '#choice_30_51_1'],
        ],
        'previous_ein_number' => [
            'type' => 'text',
            'id' => '#input_30_52',
        ],
        'recipient_email' => [
            'type' => 'text',
            'id'   => ['#input_30_3', '#input_30_3_2'],
        ],
        'recipient_phone' => [
            'type' => 'phone',
            'id' => '#input_30_4',
        ],
        'coupon' => [
            'type' => 'coupon',
            'ids' => ['#gf_coupon_code_30', '#gf_coupon_button'],
        ],
        'card_number' => [
            'type' => 'payment',
            'name' => 'input[name=cardnumber]',
        ],
        'expiration_date' => [
            'type' => 'payment',
            'name' => 'input[name=exp-date]',
        ],
        'cvc' => [
            'type' => 'payment',
            'name' => 'input[name=cvc]',
        ],
        'name_on_card' => [
            'type' => 'text',
            'id'   => '#input_30_113_5',
        ],
    ];

    protected $optionsWithPrerequisites = [
        'has_dba' => [
            0 => [],
            1 => [
                'trade_name' => 'Trade Name / Doing Business As',
            ],
        ],
        'use_different_mailing' => [
            0 => [],
            1 => [
                'mailing_address_1' => 'Mailing Address',
                'mailing_address_2' => 'Mailing Address 2',
                'mailing_city'      => 'Mailing Address > City',
                'mailing_state'     => 'Mailing Address > State',
                'mailing_zip_code'  => 'Mailing Address > Zip Code',
            ],
        ],
        'will_receive_forms_w_2' => [
            0 => [],
            1 => [
                'tax_liability_less_1000' => 'Do you expect your employment tax liability to be $1,000 or less in a full calendar year?',
                'number_agricultural_employees' => 'Number of Agricultural Employees',
                'number_other_employees' => 'Number of Other Employees',
                'first_date_wages' => 'First date wages or annuities were or will be paid',
            ],
        ],
        'primary_activity' => [
            'Accomodation' => [
                'accomodation_type' => '(Accommodation) Please choose one of the following that best describes your primary business activity: [`Casino Hotel`, `Hotel`, `Motel`, `Other`]',
            ],
            'Construction' => [
                'construction_type' => 'Do you focus on a single construction trade (concrete, framing, glass, roofing, siding, electrical, plumbing, HVAC, flooring, etc.)?',
            ],
            'Finance' => [
                'finance_type' => '(Finance) Please choose one of the following that best describes your primary business activity: [`Commodities broker`, `Credit card issuing`, `Investment advice`, `Investment club`, `Investment holding`, `Mortgage broker – agent for selling mortgages`, `Mortgage company – lending funds with real estate as collateral`, `Portfolio management`, `Sales financing`, `Securities broker`, `Trust administration`, `Venture capital company`, `Other`]',
            ],
            'Food Service' => [
                'food_service_type' => '(Food Service) Please choose one of the following that best describes your primary business activity: [`Bar`, `Bar and restaurant`, `Catering service`, `Coffee shop`, `Fast food restaurant`, `Full service restaurant`, `Ice cream shop`, `Mobile food service`, `Other`]',
            ],
            'Health Care' => [
                'health_care_type' => '(Health Care) Does your establishment include medical practitioners having the degree of M.D. (Doctor of medicine) or D.O. (Doctor of osteopathy)?',
            ],
            'Insurance' => [
                'insurance_type' => '(Insurance) Please choose one of the following that best describes your primary business activity: [`I am an insurance carrier`, `I am an insurance agent or broker`, `Other`]',
            ],
            'Manufacturing' => [
                'manufacturing_type' => 'Please specify the type of goods that you manufacture and the primary materials used (such as "wood furniture"):',
            ],
            'Real Estate' => [
                'real_estate_type' => '(Real Estate) Please choose one of the following: [`I rent or lease property that I own`, `I use capital to build property`, `I sell property for others`, `I manage real estate for others`, `Other`]',
            ],
            'Rental & Leasing' => [
                'rental_leasing_type' => '(Rental) Please choose one of the following: [`I rent, lease, or sell real estate`, `I manage real estate for others`, `I rent or lease goods`]',
            ],
            'Retail' => [
                'retail_type' => '(Retail) Please choose one of the following: [`Selling goods exclusively over the Internet (includes independently selling on auction sites)`, `Sales from a storefront`, `Direct sales`, `Auction house`, `Other`]',
            ],
            'Social Assistance' => [
                'social_assistance_type' => '(Social Assistance) Please choose one of the following that best describes your primary business activity: [`Nursing home`, `Shelter`, `Youth service`, `Other`]',
            ],
            'Transportation' => [
                'type' => '(Transportation) Do you primarily transport cargo or passengers? [`Cargo`, `Passengers`, `I provide a support activity for transportation.`]',
            ],
            'Wholesale' => [
                'wholesale_type' => 'Do you own or take title to the goods that you sell?',
            ],
            'Other' => [
                'other_type' => '(Other) Please choose one of the following: [`Consulting`, `Manufacturing`, `Organization (such as religious, environmental, social or civic, athletic, etc.)`, `Rental`, `Repair`, `Sell goods`, `Service`, `Other`]',
            ],
        ],
        'applied_for_an_ein_before' => [
            0 => [],
            1 => [
                'previous_ein_number' => 'Previous EIN Number',
            ],
        ],
    ];

    protected $validValuesForOptions = [
        'has_dba' => [true, false],
        'number_of_llc_members' => [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20],
        'state_organization_are_filed' => 'states',
        'state_business_is_located' => 'states',
        'date_entity_was_started' => 'date',
        'suffix' => ['DDS', 'MD', 'PHD', 'JR', 'SR', 'I', 'II', 'III', 'IV', 'V', 'VI'],
        'title'  => ['CEO', 'Executor', 'Owner', 'Managing Member', 'Managing Member/Owner', 'President', 'Other'],
        'use_different_mailing' => [true, false],
        'mailing_state' => 'state-code',
        'business_involves_gambling' => [true, false],
        'need_to_file_form_720' => [true, false],
        'sell_or_manufacture_alcohol_tobacco_firearms' => [true, false],
        'will_receive_forms_w_2' => [true, false],
        'applied_for_an_ein_before' => [true, false],
        'state' => 'state-code',
        'reason_for_applying' => ['Started a New Business', 'Hired New Employee(s)', 'Banking Purposes', 'Changed Type of Organization', 'Purchased Active Business'],
        'primary_activity' => ['Accomodation','Construction','Finance','Food Service','Health Care','Insurance','Manufacturing','Real Estate','Rental & Leasing','Retail','Social Assistance','Transportation','Warehousing','Wholesale','Other'],
        'accomodation_type' => ['Casino Hotel', 'Hotel', 'Motel', 'Other'],
        'construction_type' => [true, false],
        'finance_type' => [
            'Commodities broker',
            'Credit card issuing',
            'Investment advice',
            'Investment club',
            'Investment holding',
            'Mortgage broker – agent for selling mortgages',
            'Mortgage company – lending funds with real estate as collateral',
            'Portfolio management',
            'Sales financing',
            'Securities broker',
            'Trust administration',
            'Venture capital company',
            'Other',
        ],
        'food_service_type' => [
            'Bar',
            'Bar and restaurant',
            'Catering service',
            'Coffee shop',
            'Fast food restaurant',
            'Full service restaurant',
            'Ice cream shop',
            'Mobile food service',
            'Other',
        ],
        'health_care_type' => [true, false],
        'insurance_type' => [
            'I am an insurance carrier',
            'I am an insurance agent or broker',
            'Other',
        ],
        'real_estate_type' => [
            'I rent or lease property that I own',
            'I use capital to build property',
            'I sell property for others',
            'I manage real estate for others',
            'Other',
        ],
        'rental_leasing_type' => [
            'I rent, lease, or sell real estate',
            'I manage real estate for others',
            'I rent or lease goods',
        ],
        'retail_type' => [
            'Selling goods exclusively over the Internet (includes independently selling on auction sites)',
            'Sales from a storefront',
            'Direct sales',
            'Auction house',
            'Other',
        ],
        'social_assistance_type' => [
            'Nursing home',
            'Shelter',
            'Youth services',
            'Other',
        ],
        'wholesale_type' => [true, false],
        'other_type' => [
            'Consulting',
            'Manufacturing',
            'Organization (such as religious, environmental, social or civic, athletic, etc.)',
            'Rental',
            'Repair',
            'Sell goods',
            'Service',
            'Other',
        ],
        'has_highway_motor_vehicle' => [true, false],
        'recipient_email' => 'email',
        'first_date_wages' => 'date',
    ];

    protected $states = [
        'AL' => 'Alabama', 'AK' => 'Alaska', 'AZ' => 'Arizona', 'AR' => 'Arkansas', 'CA' => 'California', 'CO' => 'Colorado', 'CT' => 'Connecticut', 'DE' => 'Delaware', 'DC' => 'District of Columbia', 'FL' => 'Florida', 'GA' => 'Georgia', 'HI' => 'Hawaii', 'ID' => 'Idaho', 'IL' => 'Illinois', 'IN' => 'Indiana', 'IA' => 'Iowa', 'KS' => 'Kansas', 'KY' => 'Kentucky', 'LA' => 'Louisiana', 'ME' => 'Maine', 'MD' => 'Maryland', 'MA' => 'Massachusetts', 'MI' => 'Michigan', 'MN' => 'Minnesota', 'MS' => 'Mississippi', 'MO' => 'Missouri', 'MT' => 'Montana', 'NE' => 'Nebraska', 'NV' => 'Nevada', 'NH' => 'New Hampshire', 'NJ' => 'New Jersey', 'NM' => 'New Mexico', 'NY' => 'New York', 'NC' => 'North Carolina', 'ND' => 'North Dakota', 'OH' => 'Ohio', 'OK' => 'Oklahoma', 'OR' => 'Oregon', 'PA' => 'Pennsylvania', 'RI' => 'Rhode Island', 'SC' => 'South Carolina', 'SD' => 'South Dakota', 'TN' => 'Tennessee', 'TX' => 'Texas', 'UT' => 'Utah', 'VT' => 'Vermont', 'VA' => 'Virginia', 'WA' => 'Washington', 'WV' => 'West Virginia', 'WI' => 'Wisconsin', 'WY' => 'Wyoming', 'AA' => 'Armed Forces Americas', 'AE' => 'Armed Forces Europe', 'AP' => 'Armed Forces Pacific',
    ];

    protected $validators = [
        StateValidator::class,
        PhoneNumberValidator::class,
        SocialSecurityValidator::class,
        EmailValidator::class,
        DateValidator::class,
        DefaultValidator::class,        // must always be last on this list
    ];

    protected function getOptionPrerequisites($section, $key, $answers)
    {
        $values = array_flip($answers);

        $indexInJson = $values[$key];

        if (! array_key_exists($indexInJson, $this->jsonFileContents[$section])) {
            return false;
        }

        $answer = $this->jsonFileContents[$section][$indexInJson];

        if (array_key_exists($key, $this->optionsWithPrerequisites)) {
            $index = $answer === true ? 1 : ($answer === false ? 0 : $answer);

            // return the additional options
            return $this->optionsWithPrerequisites[$key][$index];
        }

        return false;
    }

    protected function formatAnswers($section)
    {
        $answersInJson = [];
        foreach ($this->jsonFileContents[$section] as $key => $value) {
            if ($value === true) {
                $value = 'true';
            }

            if ($value === false) {
                $value = 'false';
            }

            $answersInJson[$key] = "$key: $value";
        }

        return $answersInJson;
    }

    protected function isValueInJsonValid($section, $key, $answers, $question)
    {
        $values = array_flip($answers);

        $indexInJson = $values[$key];

        if (! array_key_exists($indexInJson, $this->jsonFileContents[$section])) {
            return false;
        }

        $answer = $this->jsonFileContents[$section][$indexInJson];

        if (! array_key_exists($key, $this->validValuesForOptions)) {
            $response = (new KeywordValidator())->handle([], $key, $answer, $question);

            if (is_string($response) && strlen($response)) {
                $this->errors[$key] = $response;
            }

            return true;
        }

        $validValuesForOptions = $this->validValuesForOptions[$key];

        // See $validators for list of supported validators.
        foreach ($this->validators as $validator) {
            $response = (new $validator())->handle($validValuesForOptions, $key, $answer, $question);

            if ($response === true) {
                return true;
            }

            if (is_string($response) && strlen($response)) {
                $this->errors[$key] = $response;
            }
        }

        return false;
    }

    protected function jsonValuesMapper($noIntervention = false)
    {
        $jsonFile = realpath($this->argument('inputJsonFile'));

        if (! $jsonFile) {
            $this->error("Could not find input file: $jsonFile. File must be a valid file path.");

            return 1;
        }

        $this->jsonFileContents = json_decode(file_get_contents($jsonFile), true);

        if ($noIntervention) {
            return $this->flattenJsonFileContents();
        }

        $indicesUsedInJson = $answers = [];
        foreach ($this->options as $section => $options) {
            $answersInJson = $this->formatAnswers($section);

            while (true) {
                $reset = false;
                foreach ($options as $key => $value) {
                    $indexUsedInJson = $this->menu("Map your answer below with to the question: `{$value}`", $answersInJson)
                        ->open();

                    $indicesUsedInJson[$indexUsedInJson] = $key;

                    $answers[$key] = $this->getValueInJson($key, $indicesUsedInJson, $section);

                    if (($indexUsedInJson != '' && ! in_array($key, ['suffix', 'coupon', 'middle_name'])) &&  ! $this->isValueInJsonValid($section, $key, $indicesUsedInJson, $value)) {
                        continue;
                    }

                    // Remove indices in json that already has been picked.
                    unset($answersInJson[$indexUsedInJson]);

                    // Remove questions from options array.
                    unset($options[$key]);

                    // if there are more options, merge and reset the loop.
                    if ($additionalOptions = $this->getOptionPrerequisites($section, $key, $indicesUsedInJson)) {
                        $options = array_merge($additionalOptions, $options);

                        $reset = true;
                        break;
                    }
                }

                if (! $reset) {
                    break;
                }
            }
        }

        return array_filter($answers);
    }

    protected function getValueInJson($key, $answers, $section)
    {
        $values = array_flip($answers);

        $indexInJson = $values[$key];

        if (! array_key_exists($indexInJson, $this->jsonFileContents[$section])) {
            return false;
        }

        return $this->jsonFileContents[$section][$indexInJson];
    }

    protected function flattenJsonFileContents()
    {
        $answers = [];

        $answersInJsonWithSection = $this->jsonFileContents;

        foreach ($answersInJsonWithSection as $answersInJson) {
            $answers = array_merge($answers, $answersInJson);
        }

        return $answers;
    }
}
