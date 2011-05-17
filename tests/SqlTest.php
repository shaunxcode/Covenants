<?php
namespace Covenants\SQL;

require_once '../src/Sql.php';
require_once '../src/Table.php';
require_once '../src/Node.php';
require_once '../src/Query.php';

use Covenants\Table;
use Phutility\Test; 

class User extends Table {}
class UserGroup extends Table {}
class SpecialGroup extends Table {}
	
$user = new User;

Test::assert("Query exists on table", method_exists($user, "query"));

$query = User::query(
	select(id, name, email, age, weight),
	where(
    	in(id, UserGroup::query(
			select(userId), 
			where(
				eq(group, 15),
				in(id, SpecialGroup::query(select(id)))))),
    	gt(age, 5),
    	gt(weight, 500)),
	group(id),
	order(name, asc),
	page(1, 4));

Test::assert("Table name is correct", $query->getTableName(), User);
Test::assert("traverse the query", $query->where->in->last()->where->eq->first(), group);
Test::assert("Simple Traversal", $query->page->first(), 1);
Test::assert("Sub Table name is correct", $query->where->in->last()->getTableName(), UserGroup);
Test::assert("Sub Sub Table Name is Correct", $query->where->in->last()->where->in->last()->getTableName(), SpecialGroup);