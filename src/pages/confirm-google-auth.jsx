import { createRoot } from '@wordpress/element';
import { useState, useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import "./scss/style.scss"

const domElement = document.getElementById(window.ytahaGoogleAuthConfirm.domElementId);

const GoogleOAuthCallback = () => {
	const [loading, setLoading] = useState(true);
	const [message, setMessage] = useState(null);

	useEffect(() => {
		const urlParams = new URLSearchParams(window.location.search);
		const code = urlParams.get('code');

		if (!code) {
			setMessage('Missing authorization code.');
			setLoading(false);
			return;
		}

		fetch('/wp-json/ytaha/v1/auth/confirm', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json',
			},
			body: JSON.stringify({ code }),
		})
			.then(response => response.json())
			.then(data => {
				if (data.status === 'success') {
					window.location.href = data.redirect_url;
				} else {
					setMessage(data.message);
					setLoading(false);
				}
			})
			.catch(err => {
				setMessage('An error occurred: ' + err.message);
				setLoading(false);
			});
	}, []);

	return (
		<>
			<div className="sui-box sui-dark">

				<div className="sui-box-header">
					<h4 className="sui-box-title">{__('Login using Google Account', 'ytaha-google-auth')}</h4>
				</div>

				<div className="sui-box-body">
					<div className="sui-box-settings-row">
						{loading ? (<div>{__('Loading...', 'ytaha-google-auth')}</div>) : (<div>{message}</div>)}
					</div>
				</div>
			</div>
		</>
	);
};

createRoot(domElement).render(<GoogleOAuthCallback />);



