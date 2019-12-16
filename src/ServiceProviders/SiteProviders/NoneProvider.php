<?php 

namespace Pantheon\TerminusBuildTools\ServiceProviders\SiteProviders;

class NoneProvider implements SiteProvider {
	protected $siteEnvironment;
    protected $machineToken;
	protected $session;
	
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

	public function createSite( array $state, array $options ) {
		log()->notice('No site will be created');
	}
}
