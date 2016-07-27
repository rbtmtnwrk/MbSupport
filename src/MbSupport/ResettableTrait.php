<?php

namespace MbSupport;

trait ResettableTrait
{
    public function reset()
    {
        $notResettable   = isset($this->notResettable) ? $this->notResettable : [];
        $notResettable[] = 'notResettable';

        foreach (get_class_vars(get_class($this)) as $key => $default) {
            (! in_array($key, $notResettable)) && $this->$key = $default;
        }

        return $this;
    }
}

/* End of file */
