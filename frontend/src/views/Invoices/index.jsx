import { useMemo, useState, useCallback, useRef } from 'react';
import { invoices } from '@data/sample/invoices';
import Table from '@components/Table';
import TableContainer from '@components/Table/Container';
import ContentView from '@components/ContentView';
import Breadcrumb from '@components/Breadcrumb';

const Invoice = (props) => {
  const columns = useMemo(
    () => [
      {
        Header: 'Invoice #',
        accessor: 'id', // accessor is the "key" in the data
        thStyle: { width: '10%' }
      },
      {
        Header: 'Customer',
        accessor: 'name', // accessor is the "key" in the data
        thStyle: { width: '20%' },
        Cell: ({ cell: { row } }) => (
          <>
            <div>{row?.original?.name}</div>
          </>
        )
      },
      {
        Header: 'Billing Address',
        accessor: 'address',
        thStyle: { width: '40%' }
      },
      {
        Header: 'Due Date',
        accessor: 'dueDate',
        thStyle: { width: '10%' }
      },
      {
        Header: 'Total',
        accessor: 'total',
        thStyle: { width: '10%' }
      }
      // {
      //   Header: '',
      //   accessor: 'action',
      //   thStyle: { width: '80px', minWidth: '80px' },
      //   Cell: ({ cell }) => (
      //     <button style={{ display: 'flex', justifyContent: 'center', alignItems: 'center' }}>
      //       <IconTimes style={{ width: '24px', height: '24px', fill: 'white' }} />
      //     </button>
      //   ),
      // },
    ],
    []
  );

  const [isLoading, setIsLoading] = useState(false);
  const [tableData, setTableData] = useState([]);

  const [pageCount, setPageCount] = useState(13);
  const fetchIdRef = useRef(0);

  const fetchData = useCallback(({ pageIndex, pageSize }) => {
    //mock fetching from server
    const fetchId = ++fetchIdRef.current;
    setIsLoading(true);
    setTimeout(() => {
      if (fetchId === fetchIdRef.current) {
        const startRow = pageSize * pageIndex;
        const endRow = startRow + pageSize;
        setTableData(invoices.slice(startRow, endRow));

        setPageCount(Math.ceil(invoices.length / pageSize));
        setIsLoading(false);
      }
    }, 500);
  }, []);

  return (
    <ContentView>
      <Breadcrumb
        title={'Manage Invoices'}
        items={[
          { text: 'Workspace', to: '/dashboard' },
          { text: 'Invoices', to: '/invoices' }
        ]}
      />

      <TableContainer
        title={'Invoices'}
        buttonCaption={'Create Invoice'}
        description={'List of invoices created by members'}>
        <Table
          columns={columns}
          data={tableData}
          isLoading={isLoading}
          pageCount={pageCount}
          fetchData={fetchData}
          showFilter={false}
          openModal={false}
        />
      </TableContainer>
    </ContentView>
  );
};

export default Invoice;
