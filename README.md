Koine Repository
-----------------

Repository classes

**Work in progress**


## Usage


```php
<?php
$storage = new \Koine\Repository\Storage\MySql($pdo, 'users');
$repository = new \Koine\Repository\Repository($storage);
$respository->setHydrator($hydrator)
  ->setEntityPrototype(new User());

// all
$users = $respository->findAll();

// first foo
$foo = $respository->findOneBy(array(
    'name' => 'foo',
));

// by name foo
$foos = $respository->findAllBy(array(
    'name' => 'foo',
));

// creating
$repository->persist(new User('bar'));

// changing
$foo->setName('bar');
$repository->persist($foo);

// removing
$repository->remove($foo);
```

```php
<?php
// sorting foos
$youngToOldFoos = $foos->sort(new MethodSorter('getBirthday'));
```

### Installing

#### Installing Via Composer
Append the lib to your requirements key in your composer.json.

```javascript
{
    // composer.json
    // [..]
    require: {
        // append this line to your requirements
        "koine/repository": "*"
    }
}
```

### Alternative install
- Learn [composer](https://getcomposer.org). You should not be looking for an alternative install. It is worth the time. Trust me ;-)
- Follow [this set of instructions](#installing-via-composer)

### Issues/Features proposals

[Here](https://github.com/koinephp/Repository/issues) is the issue tracker.

### Lincense
[MIT](MIT-LICENSE)

### Authors

- [Marcelo Jacobus](https://github.com/mjacobus)
