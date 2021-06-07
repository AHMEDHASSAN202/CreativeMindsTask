import {useState, useEffect} from 'react';
import DataTable from 'react-data-table-component';
import { Inertia } from '@inertiajs/inertia'
import SearchComponent from "./SearchComponent";
import { usePage } from '@inertiajs/inertia-react'

const SubHeaderComponent = ({subHeaderComponent='', ...props}) => {
    return (
        <>
            <SearchComponent {...props} />
            {subHeaderComponent}
        </>
    )
}

const Table = ({data: d, columns, searchServer=false, subHeaderComponent, ...props}) => {
    const {props: {queries}} = usePage();
    const [data, setData] = useState(d);
    useEffect(() => {
        setData(d);
    }, [d])
    return (
        <>
            <DataTable
                {...props}
                data={data.data}
                columns={columns}
                highlightOnHover={true}
                pagination={true}
                subHeader={true}
                subHeaderComponent={<SubHeaderComponent data={data} columns={columns} setDataFunction={setData} originalData={d} queries={queries} subHeaderComponent={subHeaderComponent} />}
                paginationTotalRows={data.total}
                paginationServer={true}
                paginationPerPage={data.per_page}
                paginationDefaultPage={data.current_page}
                onChangePage={(page, totalRows) => {
                    Inertia.get(data.path, {page: page})
                }}
                onChangeRowsPerPage={(currentRowsPerPage, currentPage) => {
                    Inertia.get(data.path, {page: currentPage, perpage: currentRowsPerPage, ...queries})
                }}
            />
        </>
    );
}

export default Table;
