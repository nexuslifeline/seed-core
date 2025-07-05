import withAuth from '@shared/hoc/withAuth';

const Dashboard = (props) => {
  return <div style={{ padding: '30px' }}>This is the Dashboard</div>;
};

export default withAuth(Dashboard);
