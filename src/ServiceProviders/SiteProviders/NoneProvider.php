<?php 

namespace Pantheon\TerminusBuildTools\ServiceProviders\SiteProviders;

class NoneProvider implements SiteProvider {
	public function getServiceName() {
		return 'none';
	}

	public function getEnvironment() {
		if ( !$this->siteEnvironment ) {
			$this->siteEnvironment = ( new SiteEnvironment() )
				->setServiceName( $this->getServiceName() );
		}
		return $this->siteEnvironment;
	}

	public function setMachineToken( $token ) {
        $this->machineToken = '';
        return $this;
    }
}