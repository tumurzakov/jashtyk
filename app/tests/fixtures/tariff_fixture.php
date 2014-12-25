<?php
/* Tariff Fixture generated on: 2010-12-28 16:12:04 : 1293532504 */
class TariffFixture extends CakeTestFixture {
	var $name = 'Tariff';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false),
		'description' => array('type' => 'string', 'null' => true, 'length' => 4096),
		'indexes' => array(),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'description' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>