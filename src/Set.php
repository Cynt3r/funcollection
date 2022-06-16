<?php
declare(strict_types = 1);

namespace Cynter\Funcollection;

use Exception;

/** Represents a set of unique values. */
class Set implements Funcollection
{
	/** @var array<int, mixed> underlying array */
	private array $val;

	/**
	 * Set constructor.
	 * @param array<int, mixed> $init initial content.
	 */
	public function __construct(array $init)
	{
		$this->val = array_unique($init);
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

	public function emptied(): Set
	{
		return new Set([]);
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

	public function filter(callable $p): Set
	{
		$arr = [];
		foreach ($this->val as $curr) {
			if ($p($curr)) {
				$arr[] = $curr;
			}
		}
		return new Set($arr);
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

	public function flatMap(callable $f): Set
	{
		$arr = [];
		foreach ($this->val as $curr) {
			array_push($arr, ...$f($curr));
		}
		return new Set($arr);
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

	public function map(callable $f): Set
	{
		$arr = [];
		foreach ($this->val as $curr) {
			$arr[] = $f($curr);
		}
		return new Set($arr);
	}

	public function nonEmpty(): bool
	{
		return !empty($this->val);
	}

	public function size(): int
	{
		return count($this->val);
	}

	/**
	 * @throws Exception when used on empty Set
	 */
	public function tail(): Set
	{
		if ($this->isEmpty()) {
			throw new Exception("Tail on empty Set");
		} else {
			return new Set(array_slice($this->val, 1));
		}
	}

	public function toArray(): array
	{
		return $this->val;
	}

	public function zip(Funcollection $that): Set
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
		return new Set($arr);
	}


	//== Set methods

	/**
	 * Deletes element from the set.
	 * @param mixed $el deleted element.
	 */
	public function delete($el): void
	{
		$this->val = $this
			->filter(fn($x) => $x !== $el)
			->toArray();
	}

	/**
	 * Creates diff of unique values of this and that (this - that).
	 * @param Set $that other set.
	 * @return Set result of diff of this and that containing only unique values (this - that).
	 */
	public function diff(Set $that): Set
	{

		$arr = array_diff($this->val, $that->toArray());
		return new Set($arr);
	}

	/**
	 * Inserts element into the set, if it's not yet present in the set.
	 * @param mixed $el inserted element.
	 */
	public function insert($el): void
	{
		if (!$this->contains($el)) {
			$this->val[] = $el;
		}
	}

	/**
	 * Creates intersect of unique values of this and that.
	 * @param Set $that other set.
	 * @return Set result of intersect of this and that containing only unique values.
	 */
	public function intersect(Set $that): Set
	{
		$arr = array_intersect($this->val, $that->toArray());
		return new Set($arr);
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
	 * Creates an arraylist from this.
	 * @return Arraylist arraylist of values from this.
	 */
	public function toArraylist(): Arraylist
	{
		return new Arraylist($this->val);
	}

	/**
	 * Creates union of unique values of this and that.
	 * @param Set $that other set.
	 * @return Set result of union of this and that containing only unique values.
	 */
	public function union(Set $that): Set
	{
		$arr = $this->val;
		foreach ($that as $curr) {
			if (!in_array($curr, $arr, true)) {
				$arr[] = $curr;
			}
		}
		return new Set($arr);
	}
}