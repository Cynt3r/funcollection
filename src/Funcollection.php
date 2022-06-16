<?php
declare(strict_types = 1);

namespace Cynter\Funcollection;

use Iterator;

/**
 * General interface for Scanbot collections/containers (inspired by Scala's Iterable)
 * @extends Iterator<int, mixed>
 */
interface Funcollection extends Iterator
{
	/**
	 * Returns true if the collection contains el
	 * @param mixed $el searched element
	 * @param bool $type_strict if true, elements are compared strictly (i.e., === is used)
	 * @return bool true if the collection contains el
	 */
	public function contains($el, bool $type_strict = false): bool;

	/**
	 * Counts the number of elements in the iterable collection which satisfy a predicate.
	 * @param callable $p the predicate used to test elements.
	 * @return int the number of elements satisfying the predicate p.
	 */
	public function count(callable $p): int;

	/**
	 * The empty iterable of the same type as this iterable.
	 * @return Funcollection an empty iterable of type self.
	 */
	public function emptied(): Funcollection;

	/**
	 * Tests whether a predicate holds for at least one element of this iterable collection.
	 * @param callable $p the predicate used to test elements.
	 * @return bool true if the given predicate p is satisfied by at least one element of this iterable collection, otherwise false
	 */
	public function exists(callable $p): bool;

	/**
	 * Selects all elements of this iterable collection which satisfy a predicate.
	 * @param callable $p
	 * @return Funcollection
	 */
	public function filter(callable $p): Funcollection;

	/**
	 * Finds the first element of the iterable collection satisfying a predicate, if any.
	 * @param callable $p the predicate used to test elements.
	 * @return Option an option value containing the first element in the iterable collection that satisfies p if exists.
	 */
	public function find(callable $p): Option;

	/**
	 * Builds a new iterable collection by applying a function to all elements of this iterable collection and using the elements of the resulting collections.
	 * @param callable $f the function to apply to each element.
	 * @return Funcollection a new iterable collection resulting from applying the given collection-valued function f to each element of this iterable collection and concatenating the results.
	 */
	public function flatMap(callable $f): Funcollection;

	/**
	 * Applies a binary operator to a start value and all elements of this iterable collection, going left to right.
	 * @param mixed $z the start value.
	 * @param callable $op the binary operator that takes the accumulated value as first argument and iterated value as the second argument.
	 * @return mixed the result of inserting op between consecutive elements of this iterable collection, left to right
	 */
	public function foldLeft($z, callable $op);

	/**
	 * Tests whether a predicate holds for all elements of this iterable collection.
	 * @param callable $p the predicate used to test elements.
	 * @return bool true if this iterable collection is empty or the given predicate p holds for all elements of this iterable collection, otherwise false.
	 */
	public function forAll(callable $p): bool;

	/**
	 * Apply f to each element for its side effects Note: [U] parameter needed to help scalac's type inference.
	 * @param callable $f the function to apply.
	 */
	public function forEach(callable $f): void;

	/**
	 * Selects the first element of this iterable collection.
	 * @return mixed the first element of this iterable collection.
	 */
	public function head();

	/**
	 * Optionally selects the first element.
	 * @return Option the first element of this iterable collection if it is nonempty if exists.
	 */
	public function headOption(): Option;

	/**
	 * Tests whether the iterable collection is empty.
	 * @return bool true if the iterable collection contains no elements, false otherwise.
	 */
	public function isEmpty(): bool;

	/**
	 * Selects the last element.
	 * @return mixed the last element of this iterable collection.
	 */
	public function last();

	/**
	 * Optionally selects the last element.
	 * @return Option the last element of this iterable collection if it is nonempty if exists.
	 */
	public function lastOption(): Option;

	/**
	 * Builds a new iterable collection by applying a function to all elements of this iterable collection.
	 * @param callable $f the function to apply to each element.
	 * @return Funcollection a new iterable collection resulting from applying the given function f to each element of this iterable collection and collecting the results.
	 */
	public function map(callable $f): Funcollection;

	/**
	 * Tests whether the iterable collection is not empty.
	 * @return bool true if the iterable collection contains at least one element, false otherwise.
	 */
	public function nonEmpty(): bool;

	/**
	 * The size of this iterable collection.
	 * @return int the number of elements in this iterable collection.
	 */
	public function size(): int;

	/**
	 * The rest of the collection without its first element.
	 * @return Funcollection the rest of the collection without its first element.
	 */
	public function tail(): Funcollection;

	/**
	 * Convert collection to array.
	 * @return array<int, mixed> the converted array
	 */
	public function toArray(): array;

	/**
	 * Returns a iterable collection formed from this iterable collection and another iterable collection by combining corresponding elements in pairs. If one of the two collections is longer than the other, its remaining elements are ignored.
	 * @param Funcollection $that the iterable providing the second half of each result pair
	 * @return Funcollection a new iterable collection containing pairs consisting of corresponding elements of this iterable collection and that. The length of the returned collection is the minimum of the lengths of this iterable collection and that.
	 */
	public function zip(Funcollection $that): Funcollection;
}
