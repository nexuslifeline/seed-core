import { create } from 'zustand';

export const useAuthStore = create((set) => ({
  authUser: null,
  acceptAuth: (data) => set({ authUser: data }),
  revokeAuth: () => set({ authUser: null })
}));
