<?php
declare(strict_types = 1);

namespace Cynter\Funcollection;

use Exception;

class Some extends Option
{
	/** @var mixed value of the Some */
	private $val;
	private bool $valid_it = true;

	/**
	 * Some constructor.
	 * @param mixed $init initial value of Some.
	 */
	public function __construct($init)
	{
		$this->val = $init;
	}


	//== Iterator methods

	/**
	 * @throws Exception
	 */
	public function current()
	{
		if ($this->valid_it) {
			return $this->val;
		} else {
			throw new Exception("Funcollection::Some out of bounds");
		}
	}

	public function next(): void
	{
		$this->valid_it = false;
	}

	public function key(): int
	{
		return $this->valid_it ? 0 : 1;
	}

	public function valid(): bool
	{
		return $this->valid_it;
	}

	public function rewind(): void
	{
		$this->valid_it = true;
	}


	//== Funcollection methods

	public function contains($el, bool $type_strict = false): bool
	{
		return $type_strict ? $this->val === $el : $this->val == $el;
	}

	public function count(callable $p): int
	{
		return $p($this->val) ? 1 : 0;
	}

	public function exists(callable $p): bool
	{
		return $p($this->val);
	}

	public function filter(callable $p): Option
	{
		return $p($this->val) ? new Some($this->val) : new None();
	}

	public function find(callable $p): Option
	{
		return $p($this->val) ? new Some($this->val) : new None();
	}

	public function flatMap(callable $f): Option
	{
		return new Some($f($this->val));
	}

	public function foldLeft($z, callable $op)
	{
		return $op($z, $this->val);
	}

	public function forAll(callable $p): bool
	{
		return $p($this->val);
	}

	public function forEach(callable $f): void
	{
		$f($this->val);
	}

	public function head()
	{
		return $this->val;
	}

	public function headOption(): Option
	{
		return new Some($this->val);
	}

	public function isEmpty(): bool
	{
		return false;
	}

	public function last()
	{
		return $this->val;
	}

	public function lastOption(): Option
	{
		return new Some($this->val);
	}

	public function map(callable $f): Funcollection
	{
		return new Some($f($this->val));
	}

	public function nonEmpty(): bool
	{
		return true;
	}

	public function size(): int
	{
		return 1;
	}

	public function tail(): ?Option
	{
		return null;
	}

	public function toArray(): array
	{
		return [$this->val];
	}

	public function zip(Funcollection $that): Option
	{
		if ($that->isEmpty()) {
			return new None();
		} else {
			return new Some([$this->val, $that->head()]);
		}
	}

	public function get()
	{
		return $this->val;
	}

	public function getOrElse($default)
	{
		return $this->val;
	}
}