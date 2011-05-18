<?php
function node($type, $vals) { return new \Covenants\Node($type, $vals); }
function enum() { return node('enum', func_get_args()); }
function eq() { return node('eq', func_get_args()); }
function gt() { return node('gt', func_get_args()); }
function group() { return node('group', func_get_args()); }
function having() { return node('having', func_get_args()); }
function in() { return node('in', func_get_args()); }
function fullJoin() { return node('fullJoin', func_get_args()); }
function leftJoin() { return node('leftJoin', func_get_args()); }
function lt() { return node('lt', func_get_args()); }
function order() { return node('order', func_get_args()); }
function page() {  return node('page', func_get_args()); }
function select() { return node('select', func_get_args()); }
function union() { return node('union', func_get_args()); }
function where() { return node('where', func_get_args()); }