# Configuration

```php
<?php

$config = [
	'model' => Models\User::class,
	'select' => ['a', 'b', 'c'],
	'sortBy' => ['ID', 'desc'],
	'query' => function($query, $rawBuilder) {
		$query->where('')->andWhere();
		$rawBuilder->select('select * from ...');
		return $query;
	},
	'perPage' => 20, // all could be -1
	'actionsDisabled' => ['delete'], // any of 'browse', 'edit', 'add', 'delete'
	'overrideTemplate' => 'path/to/template/override',
	'overrideView' => [
		'browse' => 'path/to/view/override',
		'read' => 'path/to/view/override',
		'edit' => 'path/to/view/override',
		'add' => 'path/to/view/override',
		'delete' => 'path/to/view/override',
	],
	'browse' => [
		'fields' => [
			'ID',
			'AdminID',
			'Title' => [
				'label' => 'The label value',
				'visible' => true,
				'sortable' => false,
				'searchable' => true,
				'helpText' => "Lorem ipsum dolor sit amet...",
			],
			'pre_custom_elements' => [
				'1' => '<img src="url/to/image/{{ID}}.jpg">'
			],
			'post_custom_elements' => [
				'1' => '<a href="/custom/delete/url/{{ID}}">Delete</a>',
				'2' => '<a href="/promote/{{ID}}">Promote this</a>'
			],
		],
	],
	'edit' => [
		'fields' => [
			'ID' => ['visible' => false],
			'AdminID' => ['visible' => false],
			'Title' => [
				'editable' => true,
				'visible' => true,
				'sortable' => false,
				'searchable' => true,
				'helpText' => "This is the help text for the title",
				'default' => "Default Title Value goes here",
				'type' => 'text',
				'dataSource' => function ($item, $a, $b) {
					return [1,2,3,4,5,6,7];
				},
			],
			'Medium' => [
				'custom_element_after' => '<a href=""/path/to/add/medium"">Add Medium</a>',
			],
		],
	],
	'beforeSave' => function ($model, $container) {
		//
	},
	'afterSave' => function ($model, $container) {
		//
	},
	'formGroups' => [
		"Advanced Commerce Settings 1" => [
			'fields' => [
				"AdminID", "shipping_price", 'etc_etc'
			], '
			place_after' => 'AdminID'
		],
		"Advanced Commerce Settings 2" => ['fields' => ["AdminID", "shipping_price", 'etc_etc'], 'place_at' => 'form_end'],
		"Advanced Commerce Settings 3" => ['fields' => ["AdminID", "shipping_price", 'etc_etc'], 'place_at' => 'form_beginning'],
	],
	'page' => [
		'on_page_title' => "Here is the on page title",
		'title_tag' => 'this is the title that goes in <title> element'
	],
	'navigation' => [
		'exit_url' => "/home",
		'exit_button_text' => "Exit without saving"
	],
];
```
