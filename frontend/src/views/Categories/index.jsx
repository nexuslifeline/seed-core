import { useEffect, useMemo, useState } from 'react';

import Table from '@components/Table';
import TableContainer from '@components/Table/Container';
import ContentView from '@components/ContentView';
import Breadcrumb from '@components/Breadcrumb';
import { useActiveOrganization } from '@shared/store/activeOrganization';
import { useCategoriesQuery } from '@shared/query/categories';

const Category = () => {
  const [search, setSearch] = useState('');
  const [pageCount, setPageCount] = useState(1);
  const [currentPage, setCurrentPage] = useState(1);
  const { activeOrganization } = useActiveOrganization();
  const { categories, meta, isLoading } = useCategoriesQuery(
    activeOrganization?.uuid,
    {
      params: { page: currentPage, search }
    }
  );

  const columns = useMemo(
    () => [
      {
        Header: 'Name',
        accessor: 'name',
        Cell: ({ cell: { row } }) => (
          <>
            <div>{row?.original?.name}</div>
          </>
        )
      },
      {
        Header: 'Organization',
        accessor: 'organization',
        Cell: ({ cell: { row } }) => (
          <>
            <div>{row?.original?.organization?.name}</div>
          </>
        )
      }
    ],
    []
  );

  const handlePageChange = ({ selected }) => {
    setCurrentPage(selected + 1);
  };

  useEffect(() => {
    setPageCount(Math.ceil(meta?.total / meta?.perPage || 1));
  }, [meta]);

  return (
    <ContentView>
      <Breadcrumb
        items={[
          { text: 'Workspace', to: '/dashboard' },
          { text: 'Categories', to: '/categories' }
        ]}
      />

      <TableContainer
        title={'Categories'}
        description={
          'Manage your product categories seamlessly for better inventory control.'
        }
        onSearch={setSearch}
        buttonCaption={'New Category'}>
        <Table
          data={categories || []}
          onPageChange={handlePageChange}
          {...{ pageCount, isLoading, columns }}
        />
      </TableContainer>
    </ContentView>
  );
};

export default Category;
