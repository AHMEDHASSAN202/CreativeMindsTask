import { InertiaLink } from '@inertiajs/inertia-react'

const Aside = () => {
    return (
            <div className="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto" id="kt_aside">

                <div className="brand flex-column-auto " id="kt_brand">
                    <InertiaLink href='/dashboard'  className="brand-logo">
                        <h2 className='display-4 font-weight-boldest text-light'>DASHBOARD</h2>
                    </InertiaLink>
                </div>

                <div className="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                    <div id="kt_aside_menu" className="aside-menu my-4 " data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
                        <ul className="menu-nav" id="menu-nav">
                            <li className='menu-item' aria-haspopup="true">
                                <InertiaLink
                                    id='dashboard'
                                    href={'/dashboard'}
                                    className='menu-link'
                                >
                                    <i className='menu-icon fas fa-qrcode'></i>
                                    <span className="menu-text">Dashboard</span>
                                </InertiaLink>
                            </li>
                            <li className='menu-item' aria-haspopup="true">
                                <InertiaLink
                                    id='users'
                                    href={'/dashboard/users'}
                                    className='menu-link'
                                >
                                    <i className='menu-icon flaticon2-avatar'></i>
                                    <span className="menu-text">Users</span>
                                </InertiaLink>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
    );
}

export default Aside;
