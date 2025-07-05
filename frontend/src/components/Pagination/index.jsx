import React from 'react';

import PropTypes from 'prop-types';
import ReactPaginate from 'react-paginate';

import Styles from './Pagination.module.scss';

const Pagination = ({ onPageChange, pageCount, ...props }) => {
  return (
    <ReactPaginate
      breakLabel='...'
      nextLabel='>'
      previousLabel='<'
      onPageChange={onPageChange}
      pageRangeDisplayed={5}
      pageCount={pageCount}
      renderOnZeroPageCount={null}
      containerClassName={Styles.container}
      pageClassName={Styles.page}
      nextClassName={Styles.next}
      previousClassName={Styles.previous}
      disabledClassName={Styles.disabled}
      activeClassName={Styles.active}
      {...props}
    />
  );
};

Pagination.propTypes = {
  onPageChange: PropTypes.func,
  pageCount: PropTypes.number
};

export default Pagination;
