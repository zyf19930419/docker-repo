FROM ubuntu:16.04

MAINTAINER Baker Wang <baikangwang@hotmail.com>
#Modified by Kevin <kevin8093@126.com>

#usage:
#docker run -it -v ~/Workspace/tf_serving_server:/client -p 8500:8500 --name ts_server kevin8093/tf_serving /bin/bash 
#tensorflow_model_server --model_config_file=/client/tfserv.conf

RUN sed -i 's/http:\/\/archive\.ubuntu\.com\/ubuntu\//http:\/\/mirrors\.163\.com\/ubuntu\//g' /etc/apt/sources.list

ARG DEBIAN_FRONTEND=noninteractive

# Serving port
ENV SERVING_PORT 8500

# Serving port & client port
EXPOSE $SERVING_PORT 

RUN apt update && \
    #
    # Prerequisites
    #
    apt install -y --no-install-recommends \
        build-essential g++ \
        curl git wget zip unzip \
        libfreetype6-dev \
        libpng12-dev \
        libzmq3-dev \
        pkg-config \
        python2.7 python-dev python-numpy python-pip \
        software-properties-common \
        swig \
        zlib1g-dev \
        libcurl3-dev && \
        
    # Grpc Tensorflow
    pip install --no-cache-dir --upgrade setuptools pip -i https://pypi.doubanio.com/simple && \

    pip install --no-cache-dir mock grpcio tensorflow-serving-api -i https://pypi.doubanio.com/simple && \

    pip install --no-cache-dir --upgrade tensorflow -i https://pypi.doubanio.com/simple && \
    
    #
    # Clean up
    #
    apt-get clean && \
    apt autoremove && \
    rm -rf /var/lib/apt/lists/* && \

    # Install Tensorflow Serving 1.3.0
    #
    # Install using apt-get
    echo "deb [arch=amd64] http://storage.googleapis.com/tensorflow-serving-apt stable tensorflow-model-server tensorflow-model-server-universal" | tee /etc/apt/sources.list.d/tensorflow-serving.list && \
    curl https://storage.googleapis.com/tensorflow-serving-apt/tensorflow-serving.release.pub.gpg | apt-key add - && \
    apt update && apt install tensorflow-model-server && \
    apt upgrade tensorflow-model-server && \

    #
    # Clean up
    #
    apt-get clean && \
    apt autoremove && \
    rm -rf /var/lib/apt/lists/* && \
    # client deployment directory
    cd / && \
    mkdir /client

WORKDIR /

CMD ["/bin/bash"]