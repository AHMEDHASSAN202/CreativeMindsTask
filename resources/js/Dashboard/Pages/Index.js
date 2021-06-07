import Content from "../Layout/Content";
import Layout from "../Layout/Layout";
import Topbar from "../Layout/Topbar";

const Dashboard = () => {
    return (
        <>
            <Topbar title='Dashboard' breadcrumb={[]} />
            <Content>
                <h1>Dashboard</h1>
            </Content>
        </>
    )
}

Dashboard.layout = page => <Layout children={page}/>

export default Dashboard;
