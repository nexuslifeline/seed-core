import withAuth from '@shared/hoc/withAuth';

const Expenses = (props) => {
  return <div style={{ padding: '30px' }}>This is the Expenses</div>;
};

export default withAuth(Expenses);
