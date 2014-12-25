<?php
/* RoomSession Fixture generated on: 2010-12-29 11:12:56 : 1293600776 */
class RoomSessionFixture extends CakeTestFixture {
	var $name = 'RoomSession';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 11, 'key' => 'primary'),
		'client_id' => array('type' => 'integer', 'null' => false),
		'tariff_id' => array('type' => 'integer', 'null' => false),
		'balance' => array('type' => 'float', 'null' => true),
		'start' => array('type' => 'datetime', 'null' => false),
		'end' => array('type' => 'datetime', 'null' => false),
		'created' => array('type' => 'datetime', 'null' => false),
		'modified' => array('type' => 'datetime', 'null' => false),
		'status' => array('type' => 'string', 'null' => true),
		'global_in' => array('type' => 'integer', 'null' => false),
		'global_out' => array('type' => 'integer', 'null' => false),
		'peering_in' => array('type' => 'integer', 'null' => false),
		'peering_out' => array('type' => 'integer', 'null' => false),
		'indexes' => array(),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'client_id' => 1,
			'tariff_id' => 1,
			'balance' => 1,
			'start' => '2010-12-29 11:32:56',
			'end' => '2010-12-29 11:32:56',
			'created' => '2010-12-29 11:32:56',
			'modified' => '2010-12-29 11:32:56',
			'status' => 'Lorem ipsum dolor sit amet',
			'global_in' => 1,
			'global_out' => 1,
			'peering_in' => 1,
			'peering_out' => 1
		),
	);
}
?>