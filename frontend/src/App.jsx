import React from 'react';
import { QueryClientProvider } from '@tanstack/react-query';

import { queryClient } from '@query/queryClient';
import AppRoutes from '@router';

const App = () => (
  <QueryClientProvider client={queryClient}>
    <AppRoutes />
  </QueryClientProvider>
);

export default App;
