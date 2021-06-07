import {useEffect} from 'react';
import Layout from "./../../Layout/Layout";
import Topbar from './../../Layout/Topbar';
import Content from "./../../Layout/Content";
import CardComponent from "../../Components/CardComponent";
import { useForm } from '@inertiajs/inertia-react'
import PrimaryButton from "../../Components/PrimaryButton";
import {isTrue} from "../../helpers";
import InvalidFeedBack from "../../Components/InvalidFeedback";
import Checkbox from "../../Components/Checkbox";


const breadcrumb = [
    {
        title: 'Dashboard',
        href: '/dashboard'
    },
    {
        title: 'Users',
        href: '/dashboard/users'
    }
];

const CreateEdit = (props) => {
    const {user} = props;

    const {
        data:formData,
        setData:setFormData,
        post,
        processing,
        errors,
        reset
    } = useForm({
        username: '',
        mobile: '',
        password: '',
        send_verify_code_now: false
    })

    useEffect(() => {
        if (user) {
            setFormData({username: user.username, mobile: user.mobile, password: '', _method: 'PUT'});
        }
    }, [])

    const handleSaveClick = () => {
        if (user) {
            post(`/dashboard/users/${user.id}`, {preserveScroll: true})
        }else {
            post('/dashboard/users', {
                preserveScroll: true,
                onSuccess: () => reset(),
            })
        }
    }

    return (
        <>
            <Topbar title='Create User' breadcrumb={breadcrumb} >
                <PrimaryButton
                    classes={processing ? 'spinner spinner-white spinner-left spinner-sm' : ''}
                    disabled={processing}
                    onClick={handleSaveClick}>
                    Save
                </PrimaryButton>
            </Topbar>

            <Content>
                <form id='user' >
                     <div className='row'>
                         <div className="col-md-12">
                             <CardComponent title='User Information'>
                                 <div className="form-group row">
                                     <label className="col-3 col-form-label" htmlFor="username">Username</label>
                                     <div className="col-9">
                                         <input
                                             className={'form-control' + (errors.username ? ' is-invalid' : '')}
                                             type="text"
                                             value={formData.username}
                                             id="username"
                                             onChange={(e) => setFormData('username', e.target.value)}
                                         />
                                         <InvalidFeedBack msg={errors.username}/>
                                     </div>
                                 </div>
                                 <div className="form-group row">
                                     <label className="col-3 col-form-label" htmlFor="mobile">Mobile</label>
                                     <div className="col-9">
                                         <input
                                             className={'form-control' + (errors.mobile ? ' is-invalid' : '')}
                                             type="text"
                                             value={formData.mobile}
                                             id="mobile"
                                             onChange={(e) => setFormData('mobile', e.target.value)}
                                         />
                                         <InvalidFeedBack msg={errors.mobile}/>
                                     </div>
                                 </div>
                                 <div className="form-group row">
                                     <label className="col-3 col-form-label" htmlFor="password">Password</label>
                                     <div className="col-9">
                                         <input
                                             className={'form-control' + (errors.password ? ' is-invalid' : '')}
                                             type="password"
                                             value={formData.password}
                                             id="password"
                                             onChange={(e) => setFormData('password', e.target.value)}
                                         />
                                         <InvalidFeedBack msg={errors.password}/>
                                     </div>
                                 </div>
                                 {!user ?
                                     <div className='form-group row'>
                                         <label className="col-3 col-form-label">Send verify code now</label>
                                         <div className="col-9">
                                             <Checkbox checked={isTrue(formData.send_verify_code_now)} onChange={(e) => setFormData('send_verify_code_now', e.target.checked)} label='check this option if you want to send the verification code via SMS now.'/>
                                             <InvalidFeedBack msg={errors.send_verify_code_now}/>
                                         </div>
                                     </div> : ''}
                             </CardComponent>
                         </div>
                    </div>
                </form>
            </Content>
        </>
    );
}


CreateEdit.layout = page => <Layout children={page}/>

export default CreateEdit;
