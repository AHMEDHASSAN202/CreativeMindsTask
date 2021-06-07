import {useEffect, useState} from 'react';
import { usePage } from '@inertiajs/inertia-react'

const Alert = () => {
    const {props:{alert}} = usePage();
    const [serverAlert, setServerAlert] = useState(null);

    useEffect(() => { setServerAlert(alert)}, [alert])

    if (!serverAlert) {
        return '';
    }

    return (
        <div className={'alert alert-custom alert-notice alert-light-'+serverAlert.class+' fade show mb-5'} role="alert" style={{padding: '.5rem 2rem'}}>
            <div className="alert-icon"><i className={serverAlert.icon}></i></div>
            <div className="alert-text"><strong>{serverAlert.title}</strong> </div>
            <div className="alert-close">
                <button type="button" onClick={() => setServerAlert(null)} className="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true"><i className="ki ki-close"></i></span>
                </button>
            </div>
        </div>
    );
}

export default Alert;
