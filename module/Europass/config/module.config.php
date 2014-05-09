<?php

return array (
		'service_manager' => array(
        	'invokables' => array(
        		'Europass\Model\Personaldata' => 'Europass\Model\Personaldata',
        	),
        	'factories' => array(
				'Europass\Service\EuropassService' => 'Europass\Factory\EuropassFactory',
				'Europass\Model\XmlData' => 'Europass\Factory\XmlDataFactory',
			)
		),
);