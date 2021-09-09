# PHPModelValidator
Script that checks Object models fit criteria
<h3>Hello World</h3>

<div>Create a model definition</div>

```PHP
$person['name']     = array('type'=>'string', 'required' => true);
$person['height']   = array('type'=>'float', 'required' => true);
$person['address']     = array('type'=>'object', 'required' => false);
$person['friends']  = array('type'=>'array', required=> true, minCount => 1);
```

</div>Next send an object to validate to the validator method</div>

```PHP
//Check Against Our definition
modelValid($obj, $person);
//If this failed then php exited the api and returned a 400/Bad Request with a more detailed error response
```

</div>So now we know our data fits the above model but what about our address property does that object fit the address model? Lets find out!</div>

```PHP
$address['street1']  = array('type'=>'string', 'required' => true);
$address['street2']  = array('type'=>'string', 'required' => true);
$address['company']  = array('type'=>'string', 'required' => true);
$address['city']     = array('type'=>'string', 'required' => false);
$address['state']    = array('type'=>'string', 'required' => false, 'length' => 2);
$address['zip']      = array('type'=>'string', 'required' => true);

//We know address exists at this point so no need to verify
modelValid($obj->address, $person);
```

</div>Okay that's good, so what about the friends it was verified as an array but is it an array of other $person models? Here we go!</div>

```PHP
//Reusing person model defined above
foreach($obj->friends as $friend){
        modelValid($friend, $person);
}
```

</div>Now you know every model sent to your server fits all criteria</div>
