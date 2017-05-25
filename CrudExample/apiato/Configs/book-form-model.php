<?php

return array (
  'id' => 
  array (
    'name' => 'id',
    'type' => 'text',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => true,
    'visibility' => 
    array (
      'create' => false,
      'details' => true,
      'edit' => false,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'numeric',
    ),
  ),
  'reason_id' => 
  array (
    'name' => 'reason_id',
    'type' => 'select',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'dynamicOptions' => 
    array (
      'data' => 'Reasons',
    ),
    'validation' => 
    array (
      0 => 'numeric',
      1 => 'exists:reasons,id',
    ),
  ),
  'name' => 
  array (
    'name' => 'name',
    'type' => 'text',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'required',
      1 => 'string',
    ),
  ),
  'author' => 
  array (
    'name' => 'author',
    'type' => 'text',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'required',
      1 => 'string',
    ),
  ),
  'genre' => 
  array (
    'name' => 'genre',
    'type' => 'text',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'required',
      1 => 'string',
    ),
  ),
  'stars' => 
  array (
    'name' => 'stars',
    'type' => 'number',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'numeric',
      1 => 'min:1',
      2 => 'max:5',
    ),
  ),
  'published_year' => 
  array (
    'name' => 'published_year',
    'type' => 'date',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'required',
      1 => 'date:Y',
    ),
  ),
  'enabled' => 
  array (
    'name' => 'enabled',
    'type' => 'checkbox',
    'placeholder' => '',
    'value' => '1',
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'option' => 
    array (
      'value' => 'true',
      'label' => 'Yes',
    ),
    'validation' => 
    array (
      0 => 'boolean',
    ),
  ),
  'status' => 
  array (
    'name' => 'status',
    'type' => 'radio',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'options' => 
    array (
      0 => 'setting_documents',
      1 => 'waiting_confirmation',
      2 => 'reviewing',
      3 => 'approved',
    ),
    'validation' => 
    array (
      0 => 'required',
      1 => 'string',
    ),
  ),
  'unlocking_word' => 
  array (
    'name' => 'unlocking_word',
    'type' => 'text',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => false,
      'edit' => true,
      'search' => false,
    ),
    'validation' => 
    array (
      0 => 'required',
      1 => 'string',
      2 => 'confirmed',
    ),
  ),
  'synopsis' => 
  array (
    'name' => 'synopsis',
    'type' => 'textarea',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'string',
    ),
  ),
  'approved_at' => 
  array (
    'name' => 'approved_at',
    'type' => 'datetime-local',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'date:Y-m-d H:i:s',
    ),
  ),
  'approved_by' => 
  array (
    'name' => 'approved_by',
    'type' => 'select',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => true,
      'edit' => true,
      'search' => true,
    ),
    'dynamicOptions' => 
    array (
      'data' => 'Users',
    ),
    'validation' => 
    array (
      0 => 'exists:users,id',
    ),
  ),
  'approved_password' => 
  array (
    'name' => 'approved_password',
    'type' => 'text',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => true,
      'details' => false,
      'edit' => true,
      'search' => false,
    ),
    'validation' => 
    array (
      0 => 'string',
      1 => 'confirmed',
    ),
  ),
  'created_at' => 
  array (
    'name' => 'created_at',
    'type' => 'datetime-local',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => false,
      'details' => true,
      'edit' => false,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'date:Y-m-d H:i:s',
    ),
  ),
  'updated_at' => 
  array (
    'name' => 'updated_at',
    'type' => 'datetime-local',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => false,
      'details' => true,
      'edit' => false,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'date:Y-m-d H:i:s',
    ),
  ),
  'deleted_at' => 
  array (
    'name' => 'deleted_at',
    'type' => 'datetime-local',
    'placeholder' => '',
    'value' => NULL,
    'min' => '',
    'max' => '',
    'mainWrapperClass' => 'col-sm-6',
    'labelClass' => '',
    'controlWrapperClass' => '',
    'controlClass' => '',
    'break' => false,
    'visibility' => 
    array (
      'create' => false,
      'details' => true,
      'edit' => false,
      'search' => true,
    ),
    'validation' => 
    array (
      0 => 'date:Y-m-d H:i:s',
    ),
  ),
  '_options_' => 
  array (
    'model' => 'book',
  ),
);