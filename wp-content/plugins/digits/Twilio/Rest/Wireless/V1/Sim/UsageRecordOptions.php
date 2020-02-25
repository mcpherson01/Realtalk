<?php

/**
 * This code was generated by
 * \ / _    _  _|   _  _
 * | (_)\/(_)(_|\/| |(/_  v1.0.0
 * /       /
 */

namespace Twilio\Rest\Wireless\V1\Sim;

use DateTime;
use Twilio\Options;
use Twilio\Values;

abstract class UsageRecordOptions {
    /**
     * @param DateTime $end Only include usage that has occurred on or before this
     *                       date.
     * @param DateTime $start Only include usage that has occurred on or after
     *                         this date.
     * @param string $granularity The time-based grouping that results are
     *                            aggregated by.
     * @return ReadUsageRecordOptions Options builder
     */
    public static function read($end = Values::NONE, $start = Values::NONE, $granularity = Values::NONE) {
        return new ReadUsageRecordOptions($end, $start, $granularity);
    }
}

class ReadUsageRecordOptions extends Options {
    /**
     * @param DateTime $end Only include usage that has occurred on or before this
     *                       date.
     * @param DateTime $start Only include usage that has occurred on or after
     *                         this date.
     * @param string $granularity The time-based grouping that results are
     *                            aggregated by.
     */
    public function __construct($end = Values::NONE, $start = Values::NONE, $granularity = Values::NONE) {
        $this->options['end'] = $end;
        $this->options['start'] = $start;
        $this->options['granularity'] = $granularity;
    }

    /**
     * Only include usage that has occurred on or before this date. Format is [ISO 8601](http://www.iso.org/iso/home/standards/iso8601.htm).
     * 
     * @param DateTime $end Only include usage that has occurred on or before this
     *                       date.
     * @return $this Fluent Builder
     */
    public function setEnd($end) {
        $this->options['end'] = $end;
        return $this;
    }

    /**
     * Only include usage that has occurred on or after this date. Format is [ISO 8601](http://www.iso.org/iso/home/standards/iso8601.htm).
     * 
     * @param DateTime $start Only include usage that has occurred on or after
     *                         this date.
     * @return $this Fluent Builder
     */
    public function setStart($start) {
        $this->options['start'] = $start;
        return $this;
    }

    /**
     * The time-based grouping that results are aggregated by. Valid values are `daily`, `hourly`, `all`. `all` will return one Usage Record for the entire period.
     * 
     * @param string $granularity The time-based grouping that results are
     *                            aggregated by.
     * @return $this Fluent Builder
     */
    public function setGranularity($granularity) {
        $this->options['granularity'] = $granularity;
        return $this;
    }

    /**
     * Provide a friendly representation
     * 
     * @return string Machine friendly representation
     */
    public function __toString() {
        $options = array();
        foreach ($this->options as $key => $value) {
            if ($value != Values::NONE) {
                $options[] = "$key=$value";
            }
        }
        return '[Twilio.Wireless.V1.ReadUsageRecordOptions ' . implode(' ', $options) . ']';
    }
}