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
	
	/**
     * Used to infer the provider to create from an identifier. Return
     * 'true' if this provider identifies with the URL (e.g. GithubProvider
     * expects the url to be for github.com).
     */
    public function infer( $url ) {
        return empty( $url );
    }
}