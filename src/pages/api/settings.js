import { useState } from 'react';
import apiFetch from '@wordpress/api-fetch';

/**
 * Hook to interact with google-auth settings-related APIs.
 *
 * @return {Object} Contains functions and state variables related to settings.
 */
const SettingsAPI = () => {
	// State variables for loading status and response data
	const [loading, setLoading]   = useState( false );
	const [response, setResponse] = useState( [] );

	/**
	 * Saves the provided settings.
	 *
	 * @param {string} clientId The client ID.
	 * @param {string} clientSecret The client secret.
	 */
	const saveSettings = async( clientId, clientSecret ) => {
		if (loading) {
			return;
		}

		setLoading( true );
		setResponse( [] );

		const data = { client_id: clientId, client_secret: clientSecret };

		apiFetch(
			{
				url: window.ytahaGoogleAuth.restEndpointSave,
				method: 'POST',
				data: data,
			}
		)
			.then(
				(settings) => {
                console.log( 'settings', settings );
                setResponse( settings );
				}
			)
			.catch(
				(error) => {
                if (error.code && error.message) {
                    setResponse(
                    {
                        data: { status: error.code },
                        message: error.message,
                    }
                        );
                }
				}
			)
			.finally(
				() => {
                setLoading( false );
				}
			);
	};

	return { loading, response, saveSettings };
};

export default SettingsAPI;
