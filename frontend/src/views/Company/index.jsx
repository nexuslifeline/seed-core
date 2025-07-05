import withAuth from '@shared/hoc/withAuth';

const Company = (props) => {
  return <div style={{ padding: '30px' }}>This is the Company</div>;
};

export default withAuth(Company);
