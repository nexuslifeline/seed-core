import withAuth from '@shared/hoc/withAuth';

const Tax = (props) => {
  return <div style={{ padding: '30px' }}>This is the Tax</div>;
};

export default withAuth(Tax);
