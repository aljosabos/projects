import axios from "axios";

export default axios.create({
  baseURL: "https://api.unsplash.com",
  headers: {
    Authorization: "Client-ID dxKWfNyXSgETfU5Bsx7BZ_LIzoFAp5xMbpw-7GF7UWw",
  },
});
