import { InitializationData } from '@/lycheeOrg/backend';
import axios, { type AxiosResponse } from 'axios';

const InitService = {
	fetchInitData(): Promise<AxiosResponse<InitializationData>> {
	    return axios.post('api/Session::init', {});
  },
}

export default InitService;