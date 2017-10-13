FROM tensorflow/tensorflow:1.3.0-py3

#usage: 
#docker run -it -v ~/Workspace/tf_model/notebooks:/notebooks -p 8888:8888 -p 6006:6006 kevin8093/tf_sonnet_talib

#using China mirror for ubuntu
RUN sed -i 's/http:\/\/archive\.ubuntu\.com\/ubuntu\//http:\/\/mirrors\.163\.com\/ubuntu\//g' /etc/apt/sources.list

# for configure TensorFlow Headers
ENV PYTHON_BIN_PATH=/usr/bin/python3 \
    PYTHON_LIB_PATH=/usr/local/lib/python3.5/dist-packages \
    TF_NEED_MKL=0 \
    CC_OPT_FLAGS=-march=native \
    TF_NEED_JEMALLOC=1 \
    TF_NEED_GCP=0 \
    TF_NEED_HDFS=0 \
    TF_ENABLE_XLA=0 \
    TF_NEED_VERBS=0 \
    TF_NEED_OPENCL=0 \
    TF_NEED_CUDA=0

# install git & bazel, Configure TensorFlow Headers, Build and run the installer
RUN echo "deb [arch=amd64] http://storage.googleapis.com/bazel-apt stable jdk1.8" | tee /etc/apt/sources.list.d/bazel.list && \
    curl https://bazel.build/bazel-release.pub.gpg | apt-key add - && \
    apt-get update && \
    apt-get install -y git openjdk-8-jdk bazel wget&& \
    git clone --recursive -b v1.10 https://github.com/deepmind/sonnet && \
    cd sonnet/tensorflow && \
    ./configure && \
    cd .. && \
    mkdir /tmp/sonnet && \
    bazel build --config=opt --copt="-D_GLIBCXX_USE_CXX11_ABI=0" :install && \
    ./bazel-bin/install /tmp/sonnet python3 && \
    pip3 install distribute /tmp/sonnet/*.whl

#----------------------------------------------------------------------------------------

#TA-LIB
RUN wget http://prdownloads.sourceforge.net/ta-lib/ta-lib-0.4.0-src.tar.gz && \
  tar -xvzf ta-lib-0.4.0-src.tar.gz && \
  cd ta-lib/ && \
  ./configure --prefix=/usr && \
  make && \
  make install && \
  git clone https://github.com/mrjbq7/ta-lib.git /tmp/ta-lib-py && \
  cd /tmp/ta-lib-py && python setup.py install && \

#seaborn install
<<<<<<< HEAD
    pip3 install seaborn
=======
  pip3 install seaborn
>>>>>>> origin/master

#----------------------------------------------------------------------------------------

#required by rqalpha
RUN apt-get install -y language-pack-en  && \
    locale-gen en_US.UTF-8 && \
    dpkg-reconfigure locales

ENV LC_ALL=en_US.UTF-8
ENV LANG=en_US.UTF-8
ENV LANGUAGE=en_US.UTF-8

#rqalpha
RUN pip install -U pip setuptools cython -i https://pypi.tuna.tsinghua.edu.cn/simple && \
    pip install bcolz -i https://pypi.tuna.tsinghua.edu.cn/simple && \
    pip install -i https://pypi.tuna.tsinghua.edu.cn/simple rqalpha && \
    rqalpha update_bundle && \

#----------------------------------------------------------------------------------------

    pip3 install --no-cache-dir mock grpcio && \

    rm -rf /tmp/*

# NOTE: disable authentication token for convenience. DON'T DO THIS ON A PUBLIC SERVER.
RUN echo "c.NotebookApp.ip = '*'" \
         "\nc.NotebookApp.open_browser = False" \
         "\nc.NotebookApp.token = ''" \
         > /root/.jupyter/jupyter_notebook_config.py
