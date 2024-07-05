# mpesa_api_integration_laravel
This Github repository is about the Best Mpesa API Integration code for a Laravel php website.
In case you need technical help, <b>whatsapp +254706745202</b> for immediate help.
<h3>Requirement tor Integrate Mpesa API to your Laravel website</h3>
<ol>
<li>Daraja app from developer.safaricom.co.ke where you get consumer key, consumer secret</li>
<li>An already running Laravel website</li>
<li>Access to the Laravel website php source code</li>
<li>Mpesa shortcode and passkey (These can be the Live or sandbox ones)</li>
<li>Some Php and Laravel coding skills. If not, just hire us to implement this for you. </li>
  
</ol>

<h3>Steps tp Itegrate Daraja API with Laravel from scratch</h3>

<ul>
  <li>Step 1: composer require guzzlehttp/guzzle
</li>
  <li>Check attached .evie file and ensure the contents are added to your Laravel .evie file</li>
  <li>mkdir app/Services and then add the attached mpesa_api_service.php file with its php code</li>
  <li>php artisan make:controller mpesa_Api_controller.php . copy the attached relevant file code into this controller.
</li>
  <li>Define routes as follows: use App\Http\Controllers\mpesa_ApiController;

Route::post('/mpesa/stkpush', [mpesa_ApiController::class, 'initiateStkPush']);
Route::post('/mpesa/callback', [mpesa_ApiController::class, 'mpesaCallback'])->name('mpesa.callback');
</li>

<li>You now have a route to call to /mpesa/stkpush . To this post the following data: (amount, phone, account_reference, and transaction_desc).</li>
<li>You will need to read the callback response on /mpesa/callback  . You can collect the Mpesa callback response with file_get_contents() inbuild php function and log it to see what Mpesa is sending to your aplication and complete your Mpesa payment logic</li>
</ul>

<p>This is as simple as that. You will have integrated your Laravel web application with Mpesa API (form Daraja by Safaricom)</p>
