import withAuth from '@shared/hoc/withAuth';

const Preferences = (props) => {
  return <div style={{ padding: '30px' }}>This is the Preferences</div>;
};

export default withAuth(Preferences);
