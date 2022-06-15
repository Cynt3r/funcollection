<?php
declare(strict_types = 1);

namespace Cynter\Funcollection;

/** Represents optional values. Instances of sc_option are either an instance of sc_some or the sc_none. */
abstract class Option implements Funcollection
{

	public function emptied(): Option
	{
		return new None();
	}

	/**
	 * Returns the option's value.
	 * @return mixed option's value.
	 */
	abstract public function get();

	/**
	 * Returns the option's value if the option is nonempty, otherwise return the result of evaluating default.
	 * @param mixed $default the default expression.
	 * @return mixed option's value or the default expression
	 */
	abstract public function getOrElse($default);
}