import { createRoot, createInterpolateElement } from '@wordpress/element';
import { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import { Notification, TextInput, Button } from './components';
import '@wpmudev/shared-ui/dist/js/_src/notifications.js';

import "./scss/style.scss"
import SettingsAPI from './api/settings';

const domElement = document.getElementById(window.ytahaGoogleAuth.domElementId);

const Google_Auth_Settings = () => {
	const notificationId = 'ytaha-sui-notification';
	const [clientId, setClientId] = useState(window.ytahaGoogleAuth.clientID);
	const [clientSecret, setClientSecret] = useState(window.ytahaGoogleAuth.clientSecret);
	const { loading, response, saveSettings } = SettingsAPI();

	useEffect(() => {
		let message = '';
		let status = 'error';
		if (response?.data?.status && 200 !== response.data.status) {
			message = `<p> ${response.message} </p>`;
		} else if (response?.message && '' !== response.message) {
			status = 'success';
			message = `<p> ${response.message} </p>`;
		}

		message && SUI.openNotice(notificationId, message, { type: status });

	}, [response]);

	const handleClick = async () => {
		if ('' == clientId || '' == clientSecret) {
			const message = `<p>${__('please enter valid credentials!', 'ytaha-google-auth')}</p>`;
			SUI.openNotice(notificationId, message, { type: 'error' },
				{
					dissmis: { show: true },
					autoclose: { show: false }
				});
			return;
		}
		saveSettings(clientId, clientSecret);
	}

	return (
		<>
			<div class="sui-header">
				<h1 class="sui-header-title">
					{__('Settings', 'ytaha-google-auth')}
				</h1>
			</div>

			<div className="sui-box">

				<div className="sui-box-header">
					<h2 className="sui-box-title">{__('Set Google credentials', 'ytaha-google-auth')}</h2>
				</div>

				<Notification id={notificationId} />

				<div className="sui-box-body">
					<div className="sui-box-settings-row">
						<TextInput
							id="client_id"
							value={clientId}
							help={createInterpolateElement(
								__('You can get Client ID from <a>here</a>.', 'ytaha-google-auth'),
								{
									a: <a href="https://developers.google.com/identity/gsi/web/guides/get-google-api-clientid" />,
								}
							)}
							label={__('Client ID', 'ytaha-google-auth')}
							onChange={(e) => setClientId(e.target.value)}
						/>
					</div>

					<div className="sui-box-settings-row">
						<TextInput
							id="client_secret"
							type='password'
							value={clientSecret}
							help={createInterpolateElement(
								__('You can get Client Secret from <a>here</a>.', 'ytaha-google-auth'),
								{
									a: <a href="https://developers.google.com/identity/gsi/web/guides/get-google-api-clientid" />,
								}
							)}
							label={__('Client Secret', 'ytaha-google-auth')}
							onChange={(e) => setClientSecret(e.target.value)}
						/>
					</div>

					<div className="sui-box-settings-row">
						<span> {__('Please use this url', 'ytaha-google-auth')}  <em><a href={window.ytahaGoogleAuth.returnUrl}>{window.ytahaGoogleAuth.returnUrl}</a></em>  {__('Please use this url', 'ytaha-google-auth')} <strong> {__('Authorized redirect URIs', 'ytaha-google-auth')} </strong> {__('field', 'ytaha-google-auth')}</span>
					</div>
				</div>

				<div className="sui-box-footer">
					<div className="sui-actions-left">
						<Button
							onClick={handleClick}
							loading={loading}
							label={__('Save Settings', 'ytaha-google-auth')}
							loadingLabel={__('Saving ...', 'ytaha-google-auth')}
						/>
					</div>
				</div>
			</div>
		</>
	);
}

createRoot(domElement).render(<Google_Auth_Settings />);

