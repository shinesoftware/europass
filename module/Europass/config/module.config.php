<?php

return array (
		'service_manager' => array(
        	'invokables' => array(
        		'Europass\Model\Personaldata' => 'Europass\Model\Personaldata',
        		'Europass\Model\Data' => 'Europass\Model\Data',
        	),
        	'factories' => array(
				'Europass\Service\EuropassService' => 'Europass\Factory\EuropassFactory',
			)
		),
);