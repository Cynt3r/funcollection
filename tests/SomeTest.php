<?php
declare(strict_types = 1);

use Cynter\Funcollection\Option;
use Cynter\Funcollection\None;
use Cynter\Funcollection\Some;
use PHPUnit\Framework\TestCase;

final class SomeTest extends TestCase
{
	private Option $o;

	public function setUp(): void
	{
		 $this->o = new Some(42);
	}

	public function testIter(): void
	{
		foreach ($this->o as $curr) {
			$this->assertEquals(42, $curr);
		}
	}

	public function testAccess(): void
	{
		$this->assertEquals(42, $this->o->get());
		$this->assertEquals(42, $this->o->getOrElse(666));
	}

	public function testFind(): void
	{
		$this->assertEquals(new Some(42), $this->o->find(fn($x) => $x === 42));
		$this->assertEquals(new None(), $this->o->find(fn($x) => $x === 666));
	}

	public function testToArray(): void
	{
		$this->assertEquals([42], $this->o->toArray());
	}
}