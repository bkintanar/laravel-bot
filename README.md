## About Laravel Bot

Run the command `php artisan adficient:fill-form` to start the bot.

The command has a command signature of `adficient:fill-form {inputJsonFile} {--headless} {--no-intervention}`.

- `inputJsonFile` - json file that we will use as input. There's an `input.json` file supplied as an example in the project root.
- `--headless` - when you want to run the bot in headless mode.
- `--no-intervention` - when you want to accept the json file as is as the input file for the bot. This is ideal if the keys in your json file are the same with the keys used by the bot. Otherwise, don't use this command option, and the bot will ask you to map the correct json keys yourself.

### JSON File Format

The keys in the json file are grouped into sections where the sections correspond to the sections in the form itself. These sections are mandatory.

### Screenshot Output

The screenshots will be stored in the `storage/screenshots` directory. There a total of 6 screenshot that will be generated.

- `form-before-submit.png` - When the bot is done filling up the form, it will capture a screenshot.
- `form-after-submit.png` - The bot will then do another screenshot after submitting the form. A validation check will be done after.
- `form-before-coupon-apply.png` - If there are no validation errors, it will do another screenshot when filling the coupon field in the payment screen.
- `form-after-coupon-apply.png` - The coupon field is cleared when the coupon applied is invalid. The bot also captures that screen.
- `form-before-submit-payment.png` - Before submitting the payment, the credit card details filled.
- `form-after-submit-payment.png` - It will then do a final screenshot when the submit button is clicked in the payment screen.

### Validation

I did my best to cover everything that the form has and most of the validation is done by the json mapper.

### JSON Mapper

Since the bot was developed without a proper json file input. I took the liberty to design the structure of the json file. And because
there is a high chance that the keys in the final json file that will be used will not be the same as the keys used in processing by the
bot, I've created a series of menu questions to ask the user to do the mapping manually.

This mapper can be skipped by using the `--no-intervention` option when running the bot. Just make sure that the keys used in the json input
are the same as the ones that the bot is using. Check the sample inputJsonFile supplied `input.json`.

### Running the bot

You can use the below command to run the bot.
* Remove `--no-intervention` to show the json mapper menu.
* Remove `--headless` to run the bot in head mode.

```bash
php artisan adficient:fill-form input.json --headless --no-intervention
```

The bot also shows some information on cli that can be used as logs.
