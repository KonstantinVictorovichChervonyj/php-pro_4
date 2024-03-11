<?php

interface FuelCalculator
{
    public function calculateConsumption(float $fuel, float $distance): string;
}
class Engine {
    protected float $power;
    protected float $torque;
    protected string $fuelType;

    public function __construct(string $fuelType, float $power, float $torque) {
        $this->power = $power;
        $this->torque = $torque;
        $this->fuelType = $fuelType;
    }

    public function getPower(): float {
        return $this->power;
    }
    public function getTorque(): float {
        return $this->torque;
    }
    public function getFuelType(): float {
        return $this->fuelType;
    }

    public function getInfo(): string
    {
        return "Your engine has these parameters: Power - $this->power; Torque - $this->torque; Fuel type - $this->fuelType;";
    }
}

class EuropeCar extends Engine implements FuelCalculator {
    protected string $brand;
    protected string $model;

    public function __construct(string $brand, string $model, string $fuelType) {
        parent::__construct($fuelType, 120, 150);
        $this->brand = $brand;
        $this->model = $model;
    }

    public function calculateConsumption($fuel, $distance): string
    {
        if ($distance > 0) {
            return ($fuel / $distance) * 100;
        } else {
            throw new InvalidArgumentException("Error! You can't divide by zero!");
        }
    }

    public function getInfo(): string
    {
        return "It's your Europe car $this->brand $this->model";
    }
}
class AmericanCar extends Engine implements FuelCalculator {
    protected string $brand;
    protected string $model;

    public function __construct(string $brand, string $model, string $fuelType) {
        parent::__construct($fuelType, 340, 560);
        $this->brand = $brand;
        $this->model = $model;
    }

    public function calculateConsumption($fuel, $distance): string
    {
        if ($fuel > 0) {
            return $distance / $fuel;
        } else {
            throw new InvalidArgumentException("Error! You can't divide by zero!");
        }
    }

    public function getInfo(): string
    {
        return "It's your American car $this->brand $this->model";
    }
}
class ElectricCar extends Engine {
    protected float $batteryCapacity;

    public function __construct(float $batteryCapacity) {
        parent::__construct("Electric", 120, 500);
        $this->batteryCapacity = $batteryCapacity;
    }

    public function getBatteryCapacity(): float {
        return $this->batteryCapacity;
    }
}


$gasCar = new EuropeCar('BMW', '320', 'Gasoline');
$dieselCar = new AmericanCar('Toyota', 'Land Cruiser', 'Diesel');
$electricCar = new ElectricCar(60);


echo PHP_EOL;
echo $gasCar->getInfo();
echo PHP_EOL;
echo $gasCar->calculateConsumption(20, 500);
echo PHP_EOL;
echo $dieselCar->calculateConsumption(25, 500);
echo PHP_EOL;
echo $electricCar->getPower();
echo PHP_EOL;
echo $electricCar->getBatteryCapacity();
echo PHP_EOL;

echo '=========== кінець програми ===========';
echo PHP_EOL;