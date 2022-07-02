<!DOCTYPE html>
<html>
	<head>
		<title>Jokul Checkout</title>

		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://sandbox.doku.com/jokul-checkout-js/v1/jokul-checkout-1.0.0.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	</head>
	<body>

	<h1>Jokul Checkout</h1>
	<p>Developed by : Ari Abimanyu</p>

	<p>
		Post Data is hardcoded. <br>
		Flow: JQuery Ajax Post >>> PHP file (Curl) >>> Jokul >>> Catch Response >>> Trow Url
	</p>

	<p>
		 <button id="checkout-button">Checkout Now</button>
	</p>



    <script type="text/javascript">
   		var checkoutButton = document.getElementById('checkout-button');
	    // Example: the payment page will show when the button is clicked
	    checkoutButton.addEventListener('click', function () {
	        // loadJokulCheckout('https://jokul.doku.com/checkout/link/SU5WFDferd561dfasfasdfae123c20200510090550775'); // Replace it with the response.payment.url you retrieved from the response

	       let jokul_checkout_url = '';
	       // Change with your own data 
	       let jsondata = {
						    "order": {
						        "amount": 90000,
						        "invoice_number": "INV-20210231-0001",
						        "line_items": [
						            {
						                "name": "T-Shirt Red",
						                "price": 30000,
						                "quantity": 1,
						                "sku": "1101",
						                "category": "Shirt"
						            },
						            {
						                "name": "T-Shirt Red",
						                "price": 30000,
						                "quantity": 2,
						                "sku": "1101",
						                "category": "Shirt"
						            }
						        ],
						        "currency": "IDR",
						        "auto_redirect": true,
						        "disable_retry_payment" : true,
						        "callback_url": "https://merchant.com/return-url",
						    },
						    "payment": {
						        "payment_due_date": 60,
						        "payment_method_types": [
						            "VIRTUAL_ACCOUNT_BCA",
						            "VIRTUAL_ACCOUNT_BANK_MANDIRI",
						            "VIRTUAL_ACCOUNT_BANK_SYARIAH_MANDIRI",
						            "VIRTUAL_ACCOUNT_DOKU",
						            "VIRTUAL_ACCOUNT_BRI",
						            "VIRTUAL_ACCOUNT_BNI",
						            "VIRTUAL_ACCOUNT_BANK_PERMATA",
						            "VIRTUAL_ACCOUNT_BANK_CIMB",
						            "VIRTUAL_ACCOUNT_BANK_DANAMON",
						            "ONLINE_TO_OFFLINE_ALFA",
						            "CREDIT_CARD",
						            "DIRECT_DEBIT_BRI",
						            "EMONEY_SHOPEEPAY",
						            "EMONEY_OVO",
						            "QRIS",
						            "PEER_TO_PEER_AKULAKU"
						        ]
						    },
						    "customer": {
						        "id": "CUST-0001",
						        "name": "Anton Budiman",
						        "email": "anton@example.com",
						        "phone": "6285694566147",
						        "address": "Menara Mulia Lantai 8",
						        "country": "ID"
						    }
						}

	       $.ajax({
			    url: 'jokul.php',
			    type: 'POST',
			    data: jsondata, 
    			dataType: "json",
			    success: function (data) {
			        console.log(data);
			        console.log(data.message); 
			        if (data.message == "SUCCESS")
			        {
			        	console.log(data.response.payment.url);
						jokul_checkout_url  = data.response.payment.url;
						console.log("jokul_checkout_url: " + jokul_checkout_url); 
						loadJokulCheckout(jokul_checkout_url); 
			        }
			    
			    },
			    error: function (data) {
			        console.log("error");
			        console.log(data);
			    }
			});

	    });
    </script>

	</body>
</html>