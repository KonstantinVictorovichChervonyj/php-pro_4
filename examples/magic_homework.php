<?php

class MyTestObject {
    protected array $data = [];

    public function __construct(array $initialData = []) {
        $this->data = $initialData;
    }

    public function __isset(string $name): bool {
        return isset($this->data[$name]);
    }

    public function __unset(string $name): void {
        if (isset($this->data[$name])) {
            unset($this->data[$name]);
        }
    }

    public function __invoke(): string
    {
        return print_r($this->data, true) . PHP_EOL;
    }

    public function __get(mixed $name): mixed {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, string $value): void {
        $this->data[$name] = $value;
    }

    public function __call($name, array $arguments): void {
        echo "Method call '$name' " . PHP_EOL;
        if (in_array('object', $arguments))
        {
            echo 'object context' . PHP_EOL;
        }
    }

    public static function __callStatic($name, array $arguments): void {
        echo "Static method call '$name' " . PHP_EOL;
        if (in_array('static', $arguments))
        {
            echo 'static context' . PHP_EOL;
        }
    }
}

class User
{
    protected object $objData;

    public function __construct(string $role, MyTestObject $testObject) {
        $this->objData = $testObject;
        $this->objData->role = $role;
    }

    public function __clone() {
        $this->objData = clone $this->objData;
        $this->objData->status = 'cloned';
    }
}


$dynamicObj = new MyTestObject(['name' => 'John', 'surname' => 'Smith']);

if (isset($dynamicObj->name)) {
    echo "Property 'name' exists." . PHP_EOL;
}

unset($dynamicObj->surname);
echo "After unset 'surname': " . print_r($dynamicObj, true);

echo "Name: " . $dynamicObj->name . PHP_EOL;
$dynamicObj->city = 'New York';
echo "After setting 'city': " . print_r($dynamicObj, true);

echo "Object invoked with data: " . $dynamicObj(), PHP_EOL;

$dynamicObj->runTest('object', 'test');
MyTestObject::runTest('static', 'test');

echo PHP_EOL;

$userObj = new User('tester', $dynamicObj);
$userObjSecond = clone $userObj;

echo 'Original object:';
print_r($userObj);

echo PHP_EOL;

echo 'Cloned object:';
print_r($userObjSecond);