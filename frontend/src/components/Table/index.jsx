import React, { useEffect, useState } from 'react';

import classNames from 'classnames';
import PropTypes from 'prop-types';
import { useTable } from 'react-table';

// import Loader from '@components/Loader';
import Pagination from '@components/Pagination';

import Styles from './Table.module.scss';

const Table = ({
  columns,
  data = [],
  styleOptions: { bordered, borderless, striped },
  isLoading,
  pageCount,
  onPageChange,
  ...props
}) => {
  const { getTableProps, getTableBodyProps, headerGroups, rows, prepareRow } =
    useTable({
      data,
      columns
    });

  const Rows = ({ rows }) => {
    return rows.map((row) => {
      prepareRow(row);
      return (
        <tr {...row.getRowProps()}>
          {row.cells.map((cell) => {
            return <td {...cell.getCellProps()}>{cell.render('Cell')}</td>;
          })}
        </tr>
      );
    });
  };

  return (
    <>
      <table
        {...getTableProps()}
        className={classNames(
          Styles.container,
          { [Styles.bordered]: bordered },
          { [Styles.borderless]: borderless },
          { [Styles.striped]: striped }
        )}
        {...props}>
        <thead>
          {headerGroups.map((headerGroup) => (
            <tr {...headerGroup.getHeaderGroupProps()}>
              {headerGroup.headers.map((column) => (
                <th
                  {...column.getHeaderProps({
                    style: column?.thStyle,
                    className: classNames(column?.thClass)
                  })}>
                  {column.render('Header')}
                </th>
              ))}
            </tr>
          ))}
        </thead>
        <tbody {...getTableBodyProps()}>
          <Rows rows={rows} />
        </tbody>
      </table>

      <Pagination pageCount={pageCount} onPageChange={onPageChange} />
    </>
  );
};

Table.propTypes = {
  columns: PropTypes.array.isRequired,
  styleOptions: PropTypes.object,
  isLoading: PropTypes.bool,
  onPageChange: PropTypes.func,
  pageCount: PropTypes.number
};

Table.defaultProps = {
  styleOptions: { bordered: true, borderless: true, striped: true }
};

export default Table;
