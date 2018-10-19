<?php


use App\Admin\Extensions\WangEditor;
use Encore\Admin\Form;

Form::forget(['map', 'editor']);
Form::extend('editor', WangEditor::class);

require __DIR__ . '/helpers.php';
