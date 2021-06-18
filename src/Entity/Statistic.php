<?php

namespace App\Entity;

class Statistic
{


    private int $userTotal;
    private int $projectTotal;
    private int $onGoingProjectTotal;
    private int $skillTotal;
    private int $volunteerTotal;
    private int $organizationTotal;
    private int $countryTotal;
    private int $languageTotal;

    public function __construct() {
            }

    /**
     * @return mixed
     */
    public function getUserTotal()
    {
        return $this->userTotal;
    }

    /**
     * @param mixed $userTotal
     * @return Statistic
     */
    public function setUserTotal($userTotal)
    {
        $this->userTotal = $userTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProjectTotal()
    {
        return $this->projectTotal;
    }

    /**
     * @param mixed $projectTotal
     * @return Statistic
     */
    public function setProjectTotal($projectTotal)
    {
        $this->projectTotal = $projectTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSkillTotal()
    {
        return $this->skillTotal;
    }

    /**
     * @param mixed $skillTotal
     * @return Statistic
     */
    public function setSkillTotal($skillTotal)
    {
        $this->skillTotal = $skillTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVolunteerTotal()
    {
        return $this->volunteerTotal;
    }

    /**
     * @param mixed $volunteerTotal
     * @return Statistic
     */
    public function setVolunteerTotal($volunteerTotal)
    {
        $this->volunteerTotal = $volunteerTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrganizationTotal()
    {
        return $this->organizationTotal;
    }

    /**
     * @param mixed $organizationTotal
     * @return Statistic
     */
    public function setOrganizationTotal($organizationTotal)
    {
        $this->organizationTotal = $organizationTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountryTotal()
    {
        return $this->countryTotal;
    }

    /**
     * @param mixed $countryTotal
     * @return Statistic
     */
    public function setCountryTotal($countryTotal)
    {
        $this->countryTotal = $countryTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLanguageTotal()
    {
        return $this->languageTotal;
    }

    /**
     * @param mixed $languageTotal
     * @return Statistic
     */
    public function setLanguageTotal($languageTotal)
    {
        $this->languageTotal = $languageTotal;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOnGoingProjectTotal()
    {
        return $this->onGoingProjectTotal;
    }

    /**
     * @param mixed $onGoingProjectTotal
     * @return Statistic
     */
    public function setOnGoingProjectTotal($onGoingProjectTotal)
    {
        $this->onGoingProjectTotal = $onGoingProjectTotal;
        return $this;
    }
}
