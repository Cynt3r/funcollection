<?php
declare(strict_types = 1);

namespace Cynter\Funcollection;

class Arraylist implements Funcollection
{
	/** @var array<int, mixed> underlying array */
	private array $val;

	/**
	 * Arralist constructor.
	 * @param array<int, mixed> $init initial content.
	 */
	public function __construct(array $init)
	{
		$this->val = $init;
	}


	//== Iterator methods

	public function current()
	{
		return current($this->val);
	}

	public function next(): void
	{
		next($this->val);
	}

	public function key(): int
	{
		return (int)key($this->val);
	}

	public function valid(): bool
	{
		return current($this->val) !== false;
	}

	public function rewind(): void
	{
		reset($this->val);
	}


	//== Funcollection methods

	public function contains($el, bool $type_strict = false): bool
	{
		return in_array($el, $this->val, $type_strict);
	}

	public function count(callable $p): int
	{
		$cnt = 0;
		foreach ($this as $curr) {
			if ($p($curr)) {
				$cnt++;
			}
		}
		return $cnt;
	}

	public function emptied(): Arraylist
	{
		return new Arraylist([]);
	}

	public function exists(callable $p): bool
	{
		foreach ($this->val as $curr) {
			if ($p($curr)) {
				return true;
			}
		}
		return false;
	}

	public function filter(callable $p): Arraylist
	{
		$arr = [];
		foreach ($this->val as $curr) {
			if ($p($curr)) {
				$arr[] = $curr;
			}
		}
		return new Arraylist($arr);
	}

	public function find(callable $p): Option
	{
		foreach ($this->val as $curr) {
			if ($p($curr)) {
				return new Some($curr);
			}
		}
		return new None();
	}

	public function flatMap(callable $f): Arraylist
	{
		$arr = [];
		foreach ($this->val as $curr) {
			array_push($arr, ...$f($curr));
		}
		return new Arraylist($arr);
	}

	public function foldLeft($z, callable $op)
	{
		foreach ($this->val as $curr) {
			$z = $op($z, $curr);
		}
		return $z;
	}

	public function forAll(callable $p): bool
	{
		foreach ($this->val as $curr) {
			if (!$p($curr)) {
				return false;
			}
		}
		return true;
	}

	public function forEach(callable $f): void
	{
		foreach ($this->val as $curr) {
			$f($curr);
		}
	}

	public function head()
	{
		return $this->val[0];
	}

	public function headOption(): Option
	{
		return (empty($this->val)) ? new None() : new Some($this->val[0]);
	}

	public function isEmpty(): bool
	{
		return empty($this->val);
	}

	public function last()
	{
		return $this->val[$this->size() - 1];
	}

	public function lastOption(): Option
	{
		return (empty($this->val)) ? new None() : new Some($this->val[$this->size() - 1]);
	}

	public function map(callable $f): Arraylist
	{
		$arr = [];
		foreach ($this->val as $curr) {
			$arr[] = $f($curr);
		}
		return new Arraylist($arr);
	}

	public function nonEmpty(): bool
	{
		return !empty($this->val);
	}

	public function size(): int
	{
		return count($this->val);
	}

	public function tail(): ?Arraylist
	{
		if ($this->isEmpty()) {
			return null;
		} else {
			return new Arraylist(array_slice($this->val, 1));
		}
	}

	public function toArray(): array
	{
		return $this->val;
	}

	public function zip(Funcollection $that): Arraylist
	{
		$arr = [];
		$len = min($this->size(), $that->size());

		for ($i = 0; $i < $len; $i++) {
			$arr[] = [$this->current(), $that->current()];
			$this->next();
			$that->next();
		}
		$this->rewind();
		$that->rewind();
		return new Arraylist($arr);
	}


	//== Arraylist methods


	/**
	 * Returns the element at given index.
	 * @param int $i index of the element.
	 * @return mixed the element at given index.
	 */
	public function at(int $i)
	{
		return $this->val[$i];
	}

	/**
	 * Concats arraylist with another collection.
	 * @param Funcollection $that concated collection.
	 * @return Arraylist this + that in this order.
	 */
	public function concat(Funcollection $that): Arraylist
	{
		return new Arraylist(array_merge($this->val, $that->toArray()));
	}

	/**
	 * Selects all elements except first n ones.
	 * @param int $n the number of elements to drop from this iterable collection.
	 * @return Arraylist collection consisting of all elements of this except the first n ones or empty collection if this has less than n elements.
	 */
	public function drop(int $n): Arraylist
	{
		$arr = (count($this->val) < $n) ? [] : array_slice($this->val, $n);
		return new Arraylist($arr);
	}

	/**
	 * Selects all elements except last n ones.
	 * @param int $n the number of elements to drop from this iterable collection.
	 * @return Arraylist collection consisting of all elements of this except the last n ones or empty collection if this has less than n elements.
	 */
	public function dropRight(int $n): Arraylist
	{
		$arr = (count($this->val) < $n) ? [] : array_slice($this->val, 0, -$n);
		return new Arraylist($arr);
	}

	/**
	 * Finds the largest element.
	 * @return mixed the largest element of this.
	 */
	public function max()
	{
		return max($this->val);
	}

	/**
	 * Finds the smallest element.
	 * @return mixed the smallest element of this.
	 */
	public function min()
	{
		return min($this->val);
	}

	/**
	 * Pops last element of the arraylist.
	 * @return mixed popped element.
	 */
	public function pop()
	{
		return array_pop($this->val);
	}

	/**
	 * Pops first element of the arraylist.
	 * @return mixed popped element.
	 */
	public function popFirst()
	{
		return array_shift($this->val);
	}

	/**
	 * Pushes element at the end of arraylist.
	 * @param mixed $el pushed element.
	 */
	public function push($el): void
	{
		$this->val[] = $el;
	}

	/**
	 * Pushes element at the start of arraylist.
	 * @param mixed $el pushed element.
	 */
	public function pushFirst($el): void
	{
		array_unshift($this->val, $el);
	}

	/**
	 * Returns new arraylist with elements in reversed order.
	 * @return Arraylist A new arraylist with all elements of this arraylist in reversed order.
	 */
	public function reverse(): Arraylist
	{
		return new Arraylist(array_reverse($this->val));
	}

	/**
	 * Sorts this arraylist.
	 * @return Arraylist Sorted arraylist.
	 */
	public function sort(): Arraylist
	{
		$arr = $this->val;
		sort($arr);
		return new Arraylist($arr);
	}

	/**
	 * Sorts this arraylist according to a comparison function.
	 * @param callable $comp The comparison function must return an integer less than, equal to, or greater than zero if the first argument is considered to be respectively less than, equal to, or greater than the second.
	 * @return Arraylist Sorted arraylist.
	 */
	public function sortWith(callable $comp): Arraylist
	{
		$arr = $this->val;
		usort($arr, $comp);
		return new Arraylist($arr);
	}

	/**
	 * Selects first n elements.
	 * @param int $n the number of elements to take from this iterable collection.
	 * @return Arraylist collection consisting only of the first n elements.
	 */
	public function take(int $n): Arraylist
	{
		$arr = (count($this->val) > $n) ? array_slice($this->val, 0, $n) : $this->val;
		return new Arraylist($arr);
	}

	/**
	 * Selects last n elements.
	 * @param int $n the number of elements to take from this iterable collection.
	 * @return Arraylist collection consisting only of the last n elements.
	 */
	public function takeRight(int $n): Arraylist
	{
		$arr = (count($this->val) > $n) ? array_slice($this->val, count($this->val) - $n) : $this->val;
		return new Arraylist($arr);
	}


	/**
	 * Creates a set from this.
	 * @return Set set of unique values from this.
	 */
	public function to_set(): Set
	{
		return new Set($this->val);
	}

	/**
	 * Creates a new collection containing only unique values.
	 * @return Arraylist collection containing only unique values of this.
	 */
	public function unique(): Arraylist
	{
		return new Arraylist(array_unique($this->val));
	}
}