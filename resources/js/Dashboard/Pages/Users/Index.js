import Content from "../../Layout/Content";
import Layout from "../../Layout/Layout";
import Topbar from "../../Layout/Topbar";
import DangerButton from "../../Components/DangerButton";
import {useState} from "react";
import CardComponent from "../../Components/CardComponent";
import Table from "../../Components/Table";
import EditButton from "../../Components/EditButton";
import AddButton from "../../Components/AddButton";

const Columns = [
    {
        name: 'Username',
        selector: 'username',
        sortable: true,
    },
    {
        name: 'Mobile',
        selector: 'mobile',
        sortable: true,
    },
    {
        name: 'Verified',
        selector: 'verified',
        cell: (row) => (row.mobile_verified_at == null) ? <span className='text-danger'>No</span> : <span className='text-info'>Yes</span>,
    },
    {
        name: 'actions',
        selector: 'actions',
        cell: (row) => <EditButton href={`/dashboard/users/${row.id}/edit`}/>
    }
];

const UsersIndex = ({users}) => {
    const [selected, setSelected] = useState([]);
    return (
        <>
            <Topbar title='Users' breadcrumb={[{href: '/dashboard', title: 'Dashboard'}]} >
                <AddButton href='/dashboard/users/create'/>
            </Topbar>
            <Content>
                <CardComponent title={'Users'}>
                    <Table
                        noHeader={true}
                        columns={Columns}
                        data={users}
                        keyField={'id'}
                        subHeaderComponent={<DangerButton href='/dashboard/users' method='DELETE' data={{ids: selected}} disabled={selected.length < 1}/>}
                        selectableRows={true}
                        selectableRowsHighlight={true}
                        noContextMenu={true}
                        onSelectedRowsChange={(s) => {
                            let selectedRowsId = []
                            if (s.selectedCount) {
                                selectedRowsId = s.selectedRows.map((r) => r.id)
                            }
                            setSelected(selectedRowsId);
                        }}
                    />
                </CardComponent>
            </Content>
        </>
    )
}

UsersIndex.layout = page => <Layout children={page}/>

export default UsersIndex;
