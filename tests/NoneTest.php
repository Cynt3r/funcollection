<?php
declare(strict_types = 1);

use Cynter\Funcollection\Option;
use Cynter\Funcollection\None;
use PHPUnit\Framework\TestCase;

class NoneTest extends TestCase
{
	private Option $o;

	public function setUp(): void
	{
		 $this->o = new None();
	}

	public function testIter(): void
	{
		$hit = false;
		foreach ($this->o as $curr) {
			$hit = true;
		}

		$this->assertEquals(false, $hit);
	}

	public function testWrongAccess(): void
	{
		$this->expectException(Exception::class);
		$this->o->get();
	}

	public function testCorrectAccess(): void
	{
		$this->assertEquals(666, $this->o->getOrElse(666));
	}

	public function testFind(): void
	{
		$this->assertEquals(new None(), $this->o->find(fn($x) => $x === 42));
	}

	public function testToArray(): void
	{
		$this->assertEquals([], $this->o->toArray());
	}
}