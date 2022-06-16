<?php
declare(strict_types = 1);

use Cynter\Funcollection\Arraylist;
use PHPUnit\Framework\TestCase;

class ArraylistTest extends TestCase
{
	private Arraylist $a;
	private Arraylist $b;
	private Arraylist $c;

	public function setUp(): void
	{
		 $this->a = new Arraylist([1, 2, 3]);
		 $this->b = new Arraylist([4, 5, 6]);
		 $this->c = new Arraylist([]);
	}

	public function testIter(): void
	{
		$expected = [1, 2, 3];

		foreach ($this->a as $curr) {
			$this->assertEquals(current($expected), $curr);
			next($expected);
		}
	}

	public function testHeadTail(): void
	{
		$this->assertEquals(1, $this->a->head());
		$this->assertEquals(2, $this->a->tail()->head());
		$this->assertEquals(3, $this->a->tail()->tail()->head());
		$this->assertEquals(new Arraylist([]), $this->a->tail()->tail()->tail());
	}

	public function testFilter(): void
	{
		$this->assertEquals(
			new Arraylist([2]),
			$this->a->filter(fn($x) => $x % 2 === 0),
		);
		$this->assertEquals(
			new Arraylist([]),
			$this->c->filter(fn($x) => $x % 2 === 0),
		);
	}

	public function testMap(): void
	{
		$square = fn($x) => $x * $x;

		$this->assertEquals(
			new Arraylist([1, 16, 81]),
			$this->a->map($square)->map($square),
		);
	}

	public function testZip(): void
	{
		$this->assertEquals(
			new Arraylist([[1, 4], [2, 5], [3, 6]]),
			$this->a->zip($this->b),
		);
		$this->assertEquals(
			new Arraylist([]),
			$this->a->zip($this->c),
		);
	}

	public function testFoldLeft(): void
	{
		$multiply = fn($a, $b) => $a * $b;

		$this->assertEquals(6, $this->a->foldLeft(1, $multiply));
		$this->assertEquals(1, $this->c->foldLeft(1, $multiply));
	}

	public function testForAll(): void
	{
		$this->assertTrue($this->a->forAll(fn($a) => $a > 0));
		$this->assertFalse($this->a->forAll(fn($a) => $a > 2));
		$this->assertTrue($this->c->forAll(fn($a) => $a > 0));
	}
}