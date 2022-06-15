<?php
declare(strict_types = 1);

namespace Cynter\Funcollection;

use Exception;

class None extends Option
{

	//== Iterator methods

	/**
	 * @throws Exception accessed the value of sc_none.
	 */
	public function current()
	{
		return $this->get();
	}

	public function next(): void {}

	public function key(): int
	{
		return 0;
	}

	public function valid(): bool
	{
		return false;
	}

	public function rewind(): void {}

	//== sc_collection methods

	public function contains($el, bool $type_strict = false): bool
	{
		return false;
	}

	public function count(callable $p): int
	{
		return 0;
	}

	public function exists(callable $p): bool
	{
		return false;
	}

	public function filter(callable $p): Option
	{
		return new None();
	}

	public function find(callable $p): Option
	{
		return new None();
	}

	public function flatMap(callable $f): Option
	{
		return new None();
	}

	public function foldLeft($z, callable $op)
	{
		return $z;
	}

	public function forAll(callable $p): bool
	{
		return true;
	}

	public function forEach(callable $f): void {}

	/**
	 * @throws Exception accessed the value of sc_none.
	 */
	public function head()
	{
		return $this->get();
	}

	public function headOption(): Option
	{
		return new None();
	}

	public function isEmpty(): bool
	{
		return true;
	}

	/**
	 * @throws Exception accessed the value of sc_none.
	 */
	public function last()
	{
		return $this->get();
	}

	public function lastOption(): Option
	{
		return new None();
	}

	public function map(callable $f): Option
	{
		return new None();
	}

	public function nonEmpty(): bool
	{
		return false;
	}

	public function size(): int
	{
		return 0;
	}

	public function tail(): ?Option
	{
		return null;
	}

	public function toArray(): array
	{
		return [];
	}

	public function zip(Funcollection $that): Funcollection
	{
		return new None();
	}


	//== Funcollection methods

	/**
	 * @throws Exception accessed the value of sc_none.
	 */
	public function get()
	{
		throw new Exception("Accessed the value of sc_none");
	}

	public function getOrElse($default)
	{
		return $default;
	}
}
