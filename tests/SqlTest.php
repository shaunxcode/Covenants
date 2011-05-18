<?php
namespace Covenants\SQL;

require_once '../vendor/phutility/src/Node.php';
require_once '../vendor/phutility/src/Parser.php';

require_once '../src/Sql.php';
require_once '../src/Table.php';
require_once '../src/Query.php';



use Covenants\Table;
use Covenants\Query;

use Phutility\Test; 
use Phutility\Parser; 

class User extends Table {}
class UserGroup extends Table {}
class SpecialGroup extends Table {}

Test::assert(
	"test sub expression parsing", 
	Parser::subExpressions("a b(c) dude e (f g (h i (k l m())))"), 
	array(a, b, array(c), dude, e, array(f, g, array(h, i, array(k, l, m, array())))));
	
die();
Test::assert("parse sql", Query::parse("
	SELECT id, name, email, age, weight
	  from User
	 where id in(
		select userId 
		  from UserGroup
	 	 where group = 15
	       and id in(select id from SpecialGroup))
       and age > 5
       and weight > 500 
     group by id
     order by name asc
     page 1 4", array()));
die();
	
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
Test::assert("get nth element of select", $query->select->nth(2), email);
Test::assert("get first gt", $query->where->gt->first(), 'age');
Test::assert("get second gt using find", $query->where->find(function($i) { return $i->isType(gt) && $i->first() == weight; })->first(), weight);

//lets prove that object referentiality is working as expected 
//if so we should be able to define a clause, add it, modify it
//via the variable and see that the added member has changed
$newClause = in(eyes, enum(red, blue, green));
$query->where->add($newClause);

Test::assert("get new item", $query->where->find(in, eyes)->first(), eyes);

$newClause->last()->add(purple);

Test::assert("new item in enum is there", $query->where->find(in, eyes)->last()->last(), purple);
Test::assert("find value in select", $query->select->find(age), age);



define('User_age', 'User.age');
Test::assert(
	"test sql generation", 
	User::query(where(gt(User_age, 15)))->getSql(), 
	"SELECT * FROM User WHERE User.age = 15"); 
