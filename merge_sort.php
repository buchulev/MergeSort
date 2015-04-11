<?php

/**
 *@package merge_sort.php 
 */
 
 
 
/**
 * Interface Comparable
 */
interface Comparable {
	public function compareTo($c);
}
/**
 * Class Car - trida reprezentujici auto
 * @implements Comparable
 */
class Car implements Comparable {
	public $znacka;
	public $model;
	public $velikost_motora;
	public $max_rychlost;
	public $barva;
	public $cena;
    
	/**
	 *@param $znacka
	 *@param $model 
	 *@param $velikost_motora 
	 *@param max_rychlost
	 *@param $barva  
	 *@param $cena 
	 */ 
	public function __construct($znacka, $model, $velikost_motora, $max_rychlost, $barva, $cena) {
		$this -> znacka = $znacka;
		$this -> model = $model;
		$this -> velikost_motora = $velikost_motora;
		$this -> max_rychlost = $max_rychlost;
		$this -> barva = $barva;
		$this -> cena = $cena;
	}
    /**
	 * function compare
	 * 
	 * defoltne porovnava auta podle ceny
	 * @overrides 
	 */
	public function compareTo($c) {
		if ($c instanceof Car) {
			if ($this -> cena > $c -> cena)
				return 1;
			else if ($this -> cena < $c -> cena)
				return -1;
			else
				return 0;

		}
	}
/**
 * function toString
 * 
 * @return $str vrati retezcovou reprezentaci instance Car
 */
	public function toString() {
		$str = "Znacka:" . $this -> znacka . "<br/>" . " Model : " . $this -> model . "<br/>" . " Velikost motoru : " . $this -> velikost_motora . "<br/>" . " Maximalni rychlost : " . $this -> max_rychlost . "<br/>" . " Barva : " . $this -> barva . "<br/>" . " Cena : " . $this -> cena . "<br/>";
		return $str;
	}

}
/**
 * Interface CarSpecificComparator 
 */
 
interface CarSpecificComparator {
	public function compare(Car $c1, Car $c2);
}
/**
 * @implements CarSpecificComparator
 * @see CarSpecificComparator
 * 
 * Comparator pro porovnani velikosti motoru aut
 */
class MotorComparator implements CarSpecificComparator {
	/**
	 * function compare
	 * @param $c1 Car
	 * @param $c2 Car
	 * @return int if c1 > c2 -> 1
	 *                c1 < c2 -> -1
	 *                c1 == c2 -> 0
	 */
	public function compare(Car $c1, Car $c2) {
		if ($c1 -> velikost_motora > $c2 -> velikost_motora)
			return 1;
		else if ($c1 -> velikost_motora < $c2 -> velikost_motora)
			return -1;
		else
			return 0;
	}

}

/**
 * @implements CarSpecificComparator
 * @see CarSpecificComparator
 * 
 * Comparator pro porovnani rychlosti aut
 */
class SpeedComparator implements CarSpecificComparator {
	/**
	 * function compare
	 * @param $c1 Car
	 * @param $c2 Car
	 * @return int if c1 > c2 -> 1
	 *                c1 < c2 -> -1
	 *                c1 == c2 -> 0
	 */
	public function compare(Car $c1, Car $c2) {
		if ($c1 -> max_rychlost > $c2 -> max_rychlost)
			return 1;
		else if ($c1 -> max_rychlost < $c2 -> max_rychlost)
			return -1;
		else
			return 0;
	}

}

/**
 *  Interface SortAlgorithm
 */
interface SortAlgorithm {
	public function sort($array);
}

/**
 * @implements  SortAlgorithm
 * @see SortAlgorithm
 */
class MergeSort implements SortAlgorithm {
    /*
	 *  Instance comparatoru, defoltne = null
	 */
	public $comparator = null;
    
	/**
	 * 
	 * function setComparator
	 * 
	 * Nastavi určity comparator pro instance MergeSort
	 * @param $comparator CarSpecificComparator
	 * @see CarSpecificComparator
	 */
	public function setComparator(CarSpecificComparator $comparator) {
		$this -> comparator = $comparator;
	}
    /*
	 * function SetDefaultCompareMechanism
	 * 
	 * vypina použiti komparatoru pro serazeni
	 */
	public function setDefaultCompareMechanism() {
		$this -> comparator = null;
	}
    
	/**
	 * function turnOnMotorComparison
	 * 
	 * nastavi MotorComparator jako aktualni comparator pro serazeni
	 * @see MotorComparator
	 * @uses MergeSort::setComparator(CarSpecificComparator $comparator)
	 *  
	 */
	public function turnOnMotorComparison() {
		$this -> setComparator(new MotorComparator);
	}
    
	/**
	 * function turnOnSpeedComparison
	 * 
	 * nastavi MotorComparator jako aktualni comparator pro serazeni
	 * @see SpeedComparator
	 * @uses MergeSort::setComparator(CarSpecificComparator $comparator)
	 *  
	 */
	 
	public function turnOnSpeedComparsion() {
		$this -> setComparator(new SpeedComparator);
	}

/**
 * function sort
 *
 * @param $array pole
 * @return $array seřazene pole
 * @author Levan Buchukuri
 */
 
	public function sort($array) {
		if (count($array) <= 1) {
			return $array;
		}

		$a_length = count($array);

		$mid_index = (int)($a_length / 2);

		$left_a = array();
		$right_a = array();

		for ($i = 0; $i < $mid_index; $i++) {
			$left_a[] = $array[$i];

		}

		for ($i = $mid_index; $i < $a_length; $i++) {
			$right_a[] = $array[$i];

		}

		$left_a = $this -> sort($left_a);
		$right_a = $this -> sort($right_a);

		return $this -> merge($left_a, $right_a);
	}


/**
 *
 * function merge
 *
 * @param $left_a levá čast pole
 * @param $right_a pravá čast pole
 * @return $array vrati sloučene, seřazene pole
 * @author Levan Buchukuri
 */
 
	public function merge($left_a, $right_a) {
		$array = array();

		$array_index = 0;
		$l_index = 0;
		$r_index = 0;

		while ($l_index < count($left_a) && $r_index < count($right_a)) {
			
            /* 
			 *  Je-li neni nastaven určity comparator -> použije nativni mechanismus "Car.compareTo(Car)"
			 */ 
			 
			 
			if (is_null($this -> comparator)) {

				if ($left_a[$l_index] -> compareTo($right_a[$r_index]) < 0) {

					$array[$array_index] = $left_a[$l_index];
					$l_index++;
					$array_index++;

				} else {
					$array[$array_index] = $right_a[$r_index];
					$r_index++;
					$array_index++;
				}
			} else {
                /*
				 * Jinak použije uřcity comporator pro porovnani aut
				 */ 
				if ($this -> comparator -> compare($left_a[$l_index], $right_a[$r_index]) < 0) {

					$array[$array_index] = $left_a[$l_index];
					$l_index++;
					$array_index++;

				} else {
					
					$array[$array_index] = $right_a[$r_index];
					$r_index++;
					$array_index++;
				}

			}

		}
		while ($l_index < count($left_a)) {

			$array[$array_index] = $left_a[$l_index];
			$array_index++;
			$l_index++;

		}

		while ($r_index < count($right_a)) {
			$array[$array_index] = $right_a[$r_index];
			$array_index++;
			$r_index++;

		}

		return $array;
	}

}

/** TEST 1 */////////////////////////////////////////////////////
$car1 = new Car("Audi", "V2", 30, 300, "black", 20000);
$car2 = new Car("Land Rover", "TD3", 70, 240, "white", 15000);
$car3 = new Car("Volkswagen", "Sharan", 35, 180, "red", 12000);
$car4 = new Car("Skoda", "Superb 2.0", 40, 200, "yellow", 18000);
$car5 = new Car("Ford", "S-MAX", 45, 170, "white", 14000);

$car_array = array($car1, $car2, $car3, $car4, $car5);

$sorter = new MergeSort();

echo "Defoltni serazeni(podle ceny)<br/>";

$def_sort_array = ($sorter -> sort($car_array));

foreach ($def_sort_array as $car) {
	echo "<br/>" . $car->toString();
}

echo "<br/>";
///////////////////////////////////////////////////////////////

/** TEST2 *///Compare by motor size////////////////////////////
$sorter -> turnOnMotorComparison();

echo "Serazeni podle velikosti motoru(pomoci MotorComparator)<br/>";

$motor_sort_array = $sorter -> sort($car_array);

foreach ($motor_sort_array as $car) {
	echo "<br/>" . $car->toString();
}

echo "<br/>";
///////////////////////////////////////////////////////////////

/** TEST3 *///Compare by max speed//////////////////////////////
$sorter -> turnOnSpeedComparsion();

echo "Serazeni podle max  rychlosti(pomoci SpeedComparator)<br/>";

$speed_sort_array = $sorter -> sort($car_array);

foreach ($speed_sort_array as $car) {
	echo "<br/>" . $car->toString();
}

echo "<br/>";
////////////////////////////////////////////////////////////////
?>