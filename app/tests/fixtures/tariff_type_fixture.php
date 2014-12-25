<?php
/* TariffType Fixture generated on: 2010-12-28 16:12:49 : 1293533209 */
class TariffTypeFixture extends CakeTestFixture {
	var $name = 'TariffType';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false),
		'description' => array('type' => 'string', 'null' => false),
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