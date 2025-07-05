import withAuth from '@shared/hoc/withAuth';

const Products = (props) => {
  return <div style={{ padding: '30px' }}>This is the Products</div>;
};

export default withAuth(Products);
