<?php 

namespace Pantheon\TerminusBuildTools\ServiceProviders\SiteProviders;

class NoneProvider implements SiteProvider {
	public function getServiceName() {
		return 'none';
	}

	public function getEnvironment() {
		if ( ! $this->siteEnvironment ) {
			$this->siteEnvironment = ( new SiteEnvironment() )
				->setServiceName( $this->getServiceName() );
		}
		return $this->siteEnvironment;
	}

	/**
	 * Set the machine token to access the site. Blank in this case.
	 *
	 * @param string $token
	 * @return NoneProvider
	 */
	public function setMachineToken( $token ) {
		$this->machineToken = '';
		return $this;
	}
	
	/**
	 * Used to infer the provider to create from an identifier. Return
	 * 'true' if this provider identifies with the URL (e.g. GithubProvider
	 * expects the url to be for github.com).
	 *
	 * @param string $url
	 * @return boolean
	 */
	public function infer( $url ) {
		return empty( $url );
	}
	
	public function session() {
		return $this->session;
	}

	public function setSession( $session ) {
		$this->session = $session;
		return $this;
	}
}
