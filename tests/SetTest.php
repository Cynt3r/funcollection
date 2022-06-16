<?php
declare(strict_types = 1);

use Cynter\Funcollection\Set;
use PHPUnit\Framework\TestCase;

class SetTest extends TestCase
{
	private Set $a;
	private Set $b;

	public function setUp(): void
	{
		 $this->a = new Set([1, 2, 3, 4, 5, 1]);
		 $this->b = new Set([4, 5, 6, 7, 8, 8, 8]);
	}

	public function testSize(): void
	{
		$this->assertEquals(5, $this->a->size());
		$this->assertEquals(5, $this->b->size());
	}

	public function testDiff(): void
	{
		$aDiffB = $this->a->diff($this->b);
		$bDiffA = $this->b->diff($this->a);

		$this->assertEquals(3, $aDiffB->size());
		$this->assertTrue($aDiffB->contains(1, true));
		$this->assertTrue($aDiffB->contains(2, true));
		$this->assertTrue($aDiffB->contains(3, true));
		$this->assertEquals(3, $bDiffA->size());
		$this->assertTrue($bDiffA->contains(6, true));
		$this->assertTrue($bDiffA->contains(7, true));
		$this->assertTrue($bDiffA->contains(8, true));
	}

	public function testIntersect(): void
	{
		$res = $this->a->intersect($this->b);

		$this->assertEquals(2, $res->size());
		$this->assertTrue($res->contains(4, true));
		$this->assertTrue($res->contains(5, true));
	}

	public function testUnion(): void
	{
		$res = $this->a->union($this->b);

		$this->assertEquals(8, $res->size());
		for ($i = 1; $i <= 8; $i++) {
			$this->assertTrue($res->contains($i, true));
		}
	}
}