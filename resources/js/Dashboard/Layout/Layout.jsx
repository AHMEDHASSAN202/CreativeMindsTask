import {useEffect} from "react";
import Aside from './Aside';
import Wrapper from './Wrapper';
import { usePage } from '@inertiajs/inertia-react'
import Header from './Header';
import { InertiaProgress } from '@inertiajs/progress';
import Footer from "./Footer";
InertiaProgress.init({showSpinner: true, color: '#8950fc'})


export default function Layout ({children}) {
    const {activeId} = usePage().props;

    useEffect(() => {
        document.querySelector(`#menu-nav .menu-item.menu-item-active`)?.classList.remove('menu-item-active');
        let el = document.getElementById(activeId)?.closest('.menu-item').classList.add('menu-item-active');
    })

    return (
        <>
            <Aside />
            <div className="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                <Header />

                <Wrapper>
                    {children}
                </Wrapper>

                <Footer />
            </div>
        </>
    );
}
